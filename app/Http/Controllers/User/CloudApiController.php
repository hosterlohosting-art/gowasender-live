<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CloudApi;
use App\Models\Reply;
use App\Models\Smstransaction;
use App\Models\Template;
use App\Models\User;
use App\Libraries\WhatsappLibrary;
use DB;
use Auth;
use Http;
use Session;
use Carbon\Carbon;
use App\Traits\Cloud;
use Illuminate\Support\Facades\Storage;

class CloudApiController extends Controller
{
    use Cloud;
    public $whatsapp_app_cloud_api;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cloudapis = CloudApi::where('user_id', Auth::id())->get();

        // --- NOTIFICATION SYNC: Get all unread whatsapp notifications for this user ---
        $unreadNotifications = \App\Models\Notification::where('user_id', Auth::id())
            ->where('comment', 'whatsapp-message')
            ->where('seen', 0)
            ->get();

        foreach ($cloudapis as $cloudapi) {
            // 1. Transaction Count
            $transactionCount = Smstransaction::where('user_id', Auth::id())
                ->where('cloudapi_id', $cloudapi->id)
                ->count();
            $cloudapi->smstransaction_count = $transactionCount;

            // 2. Unread Message Count (Device Specific)
            // We search for notifications where the URL contains this device's UUID
            $cloudapi->unread_messages_count = $unreadNotifications->filter(function ($n) use ($cloudapi) {
                return strpos($n->url, $cloudapi->uuid) !== false;
            })->count();
        }

        return view('user.cloudapi.index', compact('cloudapis'));
    }

    /**
     * return cloudapi statics informations
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cloudapiStatics()
    {
        $data['total'] = CloudApi::where('user_id', Auth::id())->count();
        $data['active'] = CloudApi::where('user_id', Auth::id())->where('status', 1)->count();
        $data['inActive'] = CloudApi::where('user_id', Auth::id())->where('status', 0)->count();
        $plan = Auth::user()->plan;
        if (is_string($plan)) {
            $plan = json_decode($plan);
        }
        $plan = (object) $plan;
        $limit = $plan->cloudapi_limit ?? 0;

        if ($limit == '-1') {
            $data['total'] = $data['total'];
        } else {
            $data['total'] = $data['total'] . ' / ' . $limit;
        }


        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.cloudapi.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (getUserPlanData('cloudapi_limit') == false) {
            return response()->json([
                'message' => __('Maximum CloudApi Limit Exceeded')
            ], 401);
        }

        $validated = $request->validate([
            'name' => 'required|max:100',
        ]);

        $cloudapi = new CloudApi;
        $cloudapi->user_id = Auth::id();
        $cloudapi->phone = $request->phone;
        $cloudapi->name = $request->name;
        $cloudapi->phone_number_id = $request->phone_number_id;
        $cloudapi->wa_business_id = $request->wa_business_id;
        $cloudapi->meta_app_id = $request->meta_app_id;
        $cloudapi->access_token = $request->access_token;
        $cloudapi->save();

        return response()->json([
            'redirect' => url('user/cloudapi/' . $cloudapi->uuid . '/cloud'),
            'message' => __('CloudApi Created Successfully')
        ], 200);
    }

    public function cloudApi($id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('uuid', $id)->first();
        abort_if(empty($cloudapi), 404);

        return view('user.cloudapi.hook', compact('cloudapi'));
    }

    public function checkSession($id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('uuid', $id)->first();
        abort_if(empty($cloudapi), 404);

        if ($cloudapi->status == 1) {
            $message = 'CloudApi Connected Successfully';
            return response()->json(['message' => $message]);
        }
    }

    public function setStatus($cloudapi_id, $status)
    {

        $cloudapi_id = str_replace('cloudapi_', '', $cloudapi_id);

        $cloudapi = CloudApi::where('id', $cloudapi_id)->first();
        if (!empty($cloudapi)) {
            $cloudapi->status = $status;
            $cloudapi->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('uuid', $id)->first();
        abort_if(empty($cloudapi), 404);

        $posts = Smstransaction::where('user_id', Auth::id())->where('cloudapi_id', $cloudapi->id)->latest()->paginate();
        $totalUsed = Smstransaction::where('user_id', Auth::id())->where('cloudapi_id', $cloudapi->id)->count();
        $todaysMessage = Smstransaction::where('user_id', Auth::id())->where('cloudapi_id', $cloudapi->id)->whereDate('created_at', Carbon::today())->count();
        $monthlyMessages = Smstransaction::where('user_id', Auth::id())
            ->where('cloudapi_id', $cloudapi->id)
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->count();


        return view('user.cloudapi.show', compact('cloudapi', 'posts', 'totalUsed', 'todaysMessage', 'monthlyMessages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('uuid', $id)->first();
        abort_if(empty($cloudapi), 404);
        $whatsapp_app_cloud_api = new WhatsappLibrary();
        $accessToken = $cloudapi->access_token;
        $phoneNumberId = $cloudapi->phone_number_id;
        try {
            $response = $whatsapp_app_cloud_api->fetchProfile($phoneNumberId, $accessToken);
        } catch (\Exception $e) {
            $response = []; // Prevent crash if keys are invalid
        }
        return view('user.cloudapi.edit', compact('cloudapi', 'response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 1. Validate
        $validated = $request->validate([
            'name' => 'required|max:100',
        ]);

        // 2. Find Database Entry
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('uuid', $id)->first();
        abort_if(empty($cloudapi), 404);

        // --- FIX START: Manually save the keys ---
        // This ensures your new input is actually written to the database
        if ($request->has('phone_number_id')) {
            $cloudapi->phone_number_id = $request->phone_number_id;
        }
        if ($request->has('wa_business_id')) {
            $cloudapi->wa_business_id = $request->wa_business_id;
        }
        if ($request->has('meta_app_id')) {
            $cloudapi->meta_app_id = $request->meta_app_id;
        }
        if ($request->has('access_token')) {
            $cloudapi->access_token = $request->access_token;
        }
        // --- FIX END ---

        // 3. Update Profile Info
        $cloudapi->name = $request->name;
        $cloudapi->about = $request->about;
        $cloudapi->address = $request->address;
        $cloudapi->description = $request->description;
        $cloudapi->industry = $request->industry;
        $cloudapi->email = $request->email;
        $cloudapi->website = $request->website;

        // 4. Update Meta Profile (External API)
        $whatsapp_app_cloud_api = new WhatsappLibrary();

        // Use the new keys if provided, otherwise fallback to existing
        $accessToken = $request->access_token ?? $cloudapi->access_token;
        $phoneNumberId = $request->phone_number_id ?? $cloudapi->phone_number_id;
        $appId = $request->meta_app_id ?? $cloudapi->meta_app_id;

        $profileData = [
            'messaging_product' => 'whatsapp',
            'about' => $request->about,
            'address' => $request->address,
            'description' => $request->description,
            'vertical' => $request->industry,
            'email' => $request->email,
            'websites' => [
                $request->website,
            ],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->getPathname();
            try {
                $handleResult = $whatsapp_app_cloud_api->uploadProfilePicture($filePath, $appId, $accessToken);
                $profileData['profile_picture_handle'] = $handleResult;
            } catch (\Exception $e) {
                // Ignore image upload fail
            }
        }

        // Try to update Meta, and update STATUS based on success
        try {
            $whatsapp_app_cloud_api->updateProfile($profileData, $phoneNumberId, $accessToken);
            $cloudapi->status = 1; // Connected!
        } catch (\Exception $e) {
            $cloudapi->status = 0; // Failed
            \Illuminate\Support\Facades\Log::error('Meta Update Failed: ' . $e->getMessage());
        }

        // 5. Final Save
        $cloudapi->save();

        return response()->json([
            'redirect' => url('/user/cloudapi'),
            'message' => __('CloudApi Updated Successfully')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('uuid', $id)->first();
        abort_if(empty($cloudapi), 404);
        $cloudapi->delete();

        return response()->json([
            'message' => __('Congratulations! Your CloudApi Successfully Removed'),
            'redirect' => route('user.cloudapi.index')
        ]);
    }
}