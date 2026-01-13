<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\TwoFactorCode;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.verify');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();

        if ($request->two_factor_code == $user->two_factor_code) {
            if ($user->two_factor_expires_at < now()) {
                $user->resetTwoFactorCode();
                auth()->logout();
                return redirect()->route('login')
                    ->withMessage('The two factor code has expired. Please login again.');
            }

            $user->resetTwoFactorCode();

            if ($request->input('remember_device') == '1') {
                \Illuminate\Support\Facades\Cookie::queue('device_trusted_' . $user->id, 'true', 43200); // 30 Days
            }

            // Redirect based on role
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard.index');
            } else {
                return redirect()->route('user.dashboard.index');
            }
        }

        return redirect()->back()
            ->withErrors(['two_factor_code' => 'The two factor code you entered does not match.']);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
    }
}
