<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CloudApi;
use App\Models\Smstransaction;
use App\Models\ChatMessage;
use App\Models\Schedulemessage;
use App\Models\Contact;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. INITIALIZE VARIABLES (Prevents 500 Error for New Users) ---
        $plan = null;
        $templates = null;
        $mostUsedTemplateId = null;
        $chatMessages = collect([]); // Empty collection by default

        // --- 2. FETCH MESSAGES SECURELY (The Fix) ---
        try {
            // Logic: Find the WhatsApp numbers (CloudApi) that belong to YOU.
            // Then, only show messages related to those numbers.
            $myCloudApiIds = CloudApi::where('user_id', Auth::id())->pluck('id');

            $chatMessages = ChatMessage::whereIn('cloudapi_id', $myCloudApiIds)
                ->orderBy('updated_at', 'desc')
                ->take(4)
                ->get();

        } catch (\Exception $e) {
            // BACKUP LOGIC: If 'cloudapi_id' column doesn't exist, try 'user_id' directly
            try {
                $chatMessages = ChatMessage::where('user_id', Auth::id())
                    ->orderBy('updated_at', 'desc')
                    ->take(4)
                    ->get();
            } catch (\Exception $ex) {
                // If both fail, we show 0 messages instead of crashing the site.
            }
        }

        // --- 3. PLAN & EXPIRY LOGIC ---
        // We only run this if the user has an expiry date set
        if (Auth::user()->will_expire != null) {
            $nextDate = Carbon::now()->addDays(7)->format('Y-m-d');

            if (!empty(Auth::user()->plan)) {
                $plan = json_decode(Auth::user()->plan);
            }

            try {
                $mostUsedTemplateId = Smstransaction::where('user_id', Auth::id())
                    ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                    ->whereNotNull('template_id')
                    ->groupBy('template_id')
                    ->select('template_id', DB::raw('COUNT(*) as template_count'))
                    ->orderByDesc('template_count')
                    ->first();

                if ($mostUsedTemplateId) {
                    $templates = Template::where('id', $mostUsedTemplateId->template_id)->first();
                }
            } catch (\Exception $e) {
                // Ignore template errors for new users
            }

            // Warnings for expiring plans
            if (Auth::user()->will_expire <= now()) {
                Session::flash('saas_error', __('Your subscription was expired at ' . Carbon::parse(Auth::user()->will_expire)->diffForHumans() . ' please renew the subscription'));
            } elseif (Auth::user()->will_expire <= $nextDate) {
                Session::flash('saas_error', __('Your subscription is ending in ' . Carbon::parse(Auth::user()->will_expire)->diffForHumans()));
            }
        }

        return view('user.dashboard', compact('plan', 'mostUsedTemplateId', 'templates', 'chatMessages'));
    }

    public function dashboardData()
    {
        $data['cloudapisCount'] = CloudApi::where('user_id', Auth::id())->count();
        $data['messagesCount'] = Smstransaction::where('user_id', Auth::id())->count();
        $data['contactCount'] = Contact::where('user_id', Auth::id())->count();
        $data['scheduleCount'] = Schedulemessage::where('status', 'pending')->where('user_id', Auth::id())->count();

        $data['cloudapis'] = CloudApi::where('user_id', Auth::id())->withCount('smstransaction')->orderBy('status', 'DESC')->latest()->get()->map(function ($rq) {
            $map['uuid'] = $rq->uuid;
            $map['name'] = $rq->name;
            $map['status'] = $rq->status;
            $map['phone'] = $rq->phone;
            $map['smstransaction_count'] = $rq->smstransaction_count;
            return $map;
        });

        $data['messagesStatics'] = $this->getMessagesTransaction(7);
        $data['typeStatics'] = $this->messagesStatics(7);
        $data['chatbotStatics'] = $this->getChatbotTransaction(7);
        $data['messagesAnalysis'] = Smstransaction::where('user_id', Auth::id())->whereDate('created_at', '>', Carbon::now()->subDays(30))->count();

        $data['chatbotMeter'] = Smstransaction::where('user_id', Auth::id())->where('type', 'chatbot')->whereDate('created_at', '>', Carbon::now()->subDays(30))->count();
        $data['bulkMeter'] = Smstransaction::where('user_id', Auth::id())->where('type', 'bulk-message')->whereDate('created_at', '>', Carbon::now()->subDays(30))->count();
        $data['singleMeter'] = Smstransaction::where('user_id', Auth::id())->where('type', 'single-send')->whereDate('created_at', '>', Carbon::now()->subDays(30))->count();

        return response()->json($data);
    }

    public function getMessagesTransaction($days)
    {
        return Smstransaction::where('user_id', Auth::id())
            ->where('created_at', '>', Carbon::now()->subDays($days))
            ->orderBy('created_at', 'asc')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as smstransactions')
            ->groupBy('date')
            ->get();
    }

    public function getChatbotTransaction($days)
    {
        return Smstransaction::query()
            ->where('user_id', Auth::id())
            ->where('type', 'chatbot')
            ->whereDate('created_at', '>', Carbon::now()->subDays($days))
            ->orderBy('id', 'asc')
            ->selectRaw('date(created_at) date, count(*) smstransactions')
            ->groupBy('date')
            ->get();
    }

    public function getBulkTransaction($days)
    {
        return Smstransaction::query()
            ->where('user_id', Auth::id())
            ->where('type', 'bulk-message')
            ->whereDate('created_at', '>', Carbon::now()->subDays($days))
            ->orderBy('id', 'asc')
            ->selectRaw('date(created_at) date, count(*) smstransactions')
            ->groupBy('date')
            ->get();
    }

    public function getSingleTransaction($days)
    {
        return Smstransaction::query()
            ->where('user_id', Auth::id())
            ->where('type', 'single-send')
            ->whereDate('created_at', '>', Carbon::now()->subDays($days))
            ->orderBy('id', 'asc')
            ->selectRaw('date(created_at) date, count(*) smstransactions')
            ->groupBy('date')
            ->get();
    }

    public function messagesStatics($days)
    {
        return Smstransaction::query()->where('user_id', Auth::id())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days))
            ->orderBy('id', 'asc')
            ->selectRaw('type type, count(*) smstransactions')
            ->groupBy('type')
            ->get();
    }
}