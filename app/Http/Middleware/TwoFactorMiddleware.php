<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (auth()->check() && $user->role === 'admin') {
            return $next($request);
        }

        if (auth()->check() && $user->two_factor_code) {
            \Illuminate\Support\Facades\Log::info('TwoFactorMiddleware: 2FA code found. URL: ' . $request->url());
            if (!$request->is('verify*')) {
                \Illuminate\Support\Facades\Log::info('TwoFactorMiddleware: Redirecting to verify.index');
                return redirect()->route('verify.index');
            }
        } else {
            // Log only once per session/request to avoid spam, or filtered
            // \Illuminate\Support\Facades\Log::info('TwoFactorMiddleware: Passing through (No code or verifying)');
        }

        return $next($request);
    }
}
