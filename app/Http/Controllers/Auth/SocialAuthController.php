<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Hash;
use Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google Callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists by google_id or email
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Update google_id if missing (for legacy users merging)
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }

                Auth::login($user);

                if ($user->role == 'admin') {
                    return redirect('/admin/dashboard');
                }
                return redirect('/user/dashboard');
            } else {
                // Create new user
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(16)), // Dummy password
                    'role' => 'user',
                    'status' => 1,
                    'email_verified_at' => now(), // Auto verify for Google
                    'authkey' => Str::random(20),
                ]);

                Auth::login($newUser);
                return redirect('/user/dashboard');
            }

        } catch (Exception $e) {
            // Log error or handle failure
            return redirect('/login')->with('error', 'Google Sign-In failed. Please try again.');
        }
    }
}
