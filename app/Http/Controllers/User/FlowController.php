<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FlowController extends Controller
{
    // 1. Show the list of flows
    public function index()
    {
        // Get all flows belonging to the logged-in user, including their assigned CloudApi name
        $flows = DB::table('flows')
            ->leftJoin('cloudapis', 'flows.cloudapi_id', '=', 'cloudapis.id')
            ->where('flows.user_id', Auth::id())
            ->select('flows.*', 'cloudapis.name as device_name', 'cloudapis.phone as device_phone')
            ->orderBy('flows.id', 'desc')
            ->get();

        return view('user.flows.index', compact('flows'));
    }

    // 2. Open the Visual Builder (Create New)
    public function create()
    {
        // Get user's cloudapis for the device selector
        $cloudapis = DB::table('cloudapis')->where('user_id', Auth::id())->where('status', 1)->get();
        return view('user.flows.builder', compact('cloudapis'));
    }

    // 3. Save the Flow (Fixed Version)
    public function store(Request $request)
    {
        // A. Handle the ID (Fix "null" string issue)
        $id = $request->id;
        if ($id === 'null' || empty($id)) {
            $id = null;
        }

        // B. Handle the JSON Data (Crucial Fix)
        // If the data comes as an array, we must convert it to a string string for the database
        $flowData = $request->flow_data;
        if (is_array($flowData) || is_object($flowData)) {
            $flowData = json_encode($flowData);
        }

        // C. Prepare Data
        $data = [
            'user_id' => Auth::id(),
            'cloudapi_id' => $request->cloudapi_id, // Save assigned device
            'name' => $request->name ?? 'Untitled Flow',
            'flow_data' => $flowData,
            'status' => 1,
            'updated_at' => now(),
        ];

        // D. Save or Update
        if ($id) {
            // Check if flow exists for this user
            $exists = DB::table('flows')->where('id', $id)->where('user_id', Auth::id())->exists();

            if ($exists) {
                DB::table('flows')->where('id', $id)->where('user_id', Auth::id())->update($data);
            } else {
                // If ID was sent but not found (rare error), create new
                $data['created_at'] = now();
                $id = DB::table('flows')->insertGetId($data);
            }
        } else {
            // CREATE NEW
            $data['created_at'] = now();
            $id = DB::table('flows')->insertGetId($data);
        }

        // E. Return Success with the ID (So the frontend knows which one it is)
        return response()->json([
            'success' => true,
            'id' => $id,
            'message' => 'Flow Saved Successfully'
        ]);
    }

    // 4. Edit an existing Flow
    public function edit($id)
    {
        $flow = DB::table('flows')->where('id', $id)->where('user_id', Auth::id())->first();

        // Safety check: Does this flow belong to you?
        if (!$flow)
            return redirect()->route('user.flows.index')->with('error', 'Flow not found');

        // Get user's cloudapis for the device selector
        $cloudapis = DB::table('cloudapis')->where('user_id', Auth::id())->where('status', 1)->get();

        return view('user.flows.builder', compact('flow', 'cloudapis'));
    }

    // 5. Delete a Flow
    public function destroy($id)
    {
        DB::table('flows')->where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('message', 'Flow deleted successfully');


    }
    // 6. Handle Image Upload (New Feature)
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'flow_' . time() . '.' . $image->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists(public_path('uploads/flows'))) {
                mkdir(public_path('uploads/flows'), 0777, true);
            }

            $image->move(public_path('uploads/flows'), $imageName);

            return response()->json(['url' => asset('uploads/flows/' . $imageName)]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }
}