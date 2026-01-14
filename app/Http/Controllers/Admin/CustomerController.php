<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Smstransaction;
use App\Traits\Notifications;
use DB;
use Auth;
use Hash;
class CustomerController extends Controller
{

    use Notifications;

    public function __construct()
    {
        $this->middleware('permission:customer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = User::query();

        if (!empty($request->search)) {
            $customers = $customers->where($request->type, 'LIKE', '%' . $request->search . '%');
        }

        $customers = $customers->where('role', 'user')->with('subscription')->withCount('orders')->latest()->paginate(20);
        $type = $request->type ?? '';

        $totalCustomers = User::where('role', 'user')->count();
        $totalActiveCustomers = User::where('role', 'user')->where('status', 1)->count();
        $totalSuspendedCustomers = User::where('role', 'user')->where('status', 0)->count();
        $totalExpiredCustomers = User::where('role', 'user')->where('will_expire', '<=', now())->count();

        $plans = Plan::where('status', 1)->get();

        return view('admin.customers.index', compact('customers', 'request', 'type', 'totalCustomers', 'totalActiveCustomers', 'totalSuspendedCustomers', 'totalExpiredCustomers', 'plans'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = User::query()->withCount('orders')->withCount('contact')->withCount('cloudapi')->withSum('orders', 'amount')->withCount('smstransaction')->with('subscription')->findorFail($id);
        $orders = Order::where('user_id', $id)->with('plan', 'gateway')->latest()->paginate(20);

        return view('admin.customers.show', compact('customer', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::query()->where('role', 'user')->findorFail($id);

        return view('admin.customers.edit', compact('customer'));
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
        $validatedData = $request->validate([
            'password' => ['nullable', 'min:8', 'max:100'],
            'name' => ['required', 'string'],
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|numeric|unique:users,phone,' . $id,
        ]);

        $customer = User::query()->where('role', 'user')->findorFail($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->status = $request->status;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        if ($request->password) {
            $customer->password = Hash::make($request->password);
        }
        $customer->save();

        $title = 'Your account information has changed by admin';

        $notification['user_id'] = $customer->id;
        $notification['title'] = $title;
        $notification['url'] = '/user/profile';

        $this->createNotification($notification);

        return response()->json([
            'redirect' => route('admin.customer.index'),
            'message' => __('User Updated successfully.')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('role', 'user')->findorFail($id);
        $user->delete();

        return response()->json([
            'redirect' => route('admin.customer.index'),
            'message' => __('User deleted successfully.')
        ]);
    }

    public function assignPlan(Request $request, $id)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $user = User::where('role', 'user')->findOrFail($id);
        $plan = Plan::findOrFail($request->plan_id);

        $user->plan_id = $plan->id;
        $user->plan = json_encode($plan->data ?? []);

        if ($plan->days == 365) {
            $user->will_expire = now()->addYear();
        } elseif ($plan->days == 30) {
            $user->will_expire = now()->addMonth();
        } else {
            $user->will_expire = now()->addDays($plan->days);
        }

        $user->save();

        // Optional: Create a dummy order entry if needed for records, but user asked for "manually update" so likely just updating user record is sufficient.
        // We can send a notification though.

        $title = 'Your subscription plan has been updated by admin';

        $notification['user_id'] = $user->id;
        $notification['title'] = $title;
        $notification['url'] = '/user/subscription-history';

        $this->createNotification($notification);

        return response()->json([
            'redirect' => route('admin.customer.index'),
            'message' => __('Plan assigned successfully.')
        ]);
    }
}
