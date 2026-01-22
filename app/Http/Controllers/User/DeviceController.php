<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Traits\DeviceTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    use DeviceTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::where('user_id', Auth::id())->latest()->get();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add Device'),
                'url' => '#',
                'components' => 'data-toggle="modal" data-target="#addDevice"',
                'is_button' => true
            ]
        ];
        return view('user.devices.index', compact('devices', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $device = Device::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'status' => 0,
        ]);

        return response()->json([
            'redirect' => route('user.device.scan', $device->uuid),
            'message' => __('Device Created Successfully. Please scan the QR code.')
        ], 200);
    }

    /**
     * Show the scan page for a device.
     */
    public function scan($uuid)
    {
        $device = Device::where('user_id', Auth::id())->where('uuid', $uuid)->firstOrFail();
        return view('user.devices.scan', compact('device'));
    }

    /**
     * Get the QR code for a device.
     */
    public function getQr($uuid)
    {
        $device = Device::where('user_id', Auth::id())->where('uuid', $uuid)->firstOrFail();

        // Try to create/get session from Node.js server
        $response = $this->createSession($device->uuid);

        if (isset($response['success']) && $response['success']) {
            return response()->json([
                'success' => true,
                'qr' => $response['qr'] ?? '',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'] ?? __('Failed to connect to WhatsApp server'),
            'debug' => $response // For debugging
        ], 500);
    }

    /**
     * Check the status of a device.
     */
    public function checkStatus($uuid)
    {
        $device = Device::where('user_id', Auth::id())->where('uuid', $uuid)->firstOrFail();

        $response = $this->getSessionStatus($device->uuid);

        if (isset($response['success']) && $response['success'] && $response['status'] === 'CONNECTED') {
            $device->update(['status' => 1]);
            return response()->json([
                'connected' => true,
                'message' => __('Connected Successfully')
            ]);
        }

        return response()->json([
            'connected' => false,
            'status' => $response['status'] ?? 'DISCONNECTED'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $device = Device::where('user_id', Auth::id())->where('uuid', $uuid)->firstOrFail();

        // Optionally delete session from Node.js server
        $this->deleteSession($device->uuid);

        $device->delete();

        return response()->json([
            'message' => __('Device Removed Successfully'),
            'redirect' => route('user.device.index')
        ]);
    }
}
