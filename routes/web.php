<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\BulkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Webhook Route
Route::match(['get', 'post'], '/send-webhook/{cloudapi_id}', [BulkController::class, 'webHook']);

// Google Auth Routes
Route::get('login/google', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback']);

// Two Factor Auth Routes
Route::get('verify-2fa', [App\Http\Controllers\Auth\TwoFactorController::class, 'index'])->name('verify.index')->middleware('auth');
Route::post('verify-2fa', [App\Http\Controllers\Auth\TwoFactorController::class, 'store'])->name('verify.store')->middleware('auth');
Route::get('verify-2fa/resend', [App\Http\Controllers\Auth\TwoFactorController::class, 'resend'])->name('verify.resend')->middleware('auth');

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//**======================== CRON Routes ====================**//
Route::group(['prefix' => 'cron', 'as' => 'cron.'], function () {
    Route::get('/execute-schedule', [App\Http\Controllers\CronController::class, 'ExecuteSchedule']);
    Route::get('/notify-to-user', [App\Http\Controllers\CronController::class, 'notifyToUser']);
    Route::get('/remove-junk-cloudapi', [App\Http\Controllers\CronController::class, 'removeJunkCloudApi']);
});

//**======================== Flow Builder Routes ====================**//
// These are now OUTSIDE the cron group, so the URL will be /user/flows
Route::middleware(['auth', 'web'])->prefix('user')->group(function () {
    Route::get('/flows', [App\Http\Controllers\User\FlowController::class, 'index'])->name('user.flows.index');
    Route::get('/flows/create', [App\Http\Controllers\User\FlowController::class, 'create'])->name('user.flows.create');
    Route::post('/flows/save', [App\Http\Controllers\User\FlowController::class, 'store'])->name('user.flows.store');
    Route::post('/flows/upload-image', [App\Http\Controllers\User\FlowController::class, 'uploadImage'])->name('user.flows.upload');
    Route::get('/flows/edit/{id}', [App\Http\Controllers\User\FlowController::class, 'edit'])->name('user.flows.edit');
    Route::get('/flows/delete/{id}', [App\Http\Controllers\User\FlowController::class, 'destroy'])->name('user.flows.delete');
});

//**======================== Payment Gateway Route Group for merchant ====================**//
Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/payment/paypal', '\App\Gateway\Paypal@status');
    Route::post('/stripe/payment', '\App\Gateway\Stripe@status')->name('stripe.payment');
    Route::get('/stripe', '\App\Gateway\Stripe@view')->name('stripe.view');
    Route::get('/stripe-pay/success', '\App\Gateway\Stripe@status')->name('stripe.success');
    Route::get('/stripe-pay/fail', '\App\Gateway\Stripe@fail')->name('stripe.fail');

    Route::get('/payment/mollie', '\App\Gateway\Mollie@status');
    Route::post('/payment/paystack', '\App\Gateway\Paystack@status')->name('paystack.status');
    Route::get('/paystack', '\App\Gateway\Paystack@view')->name('paystack.view');
    Route::get('/payment/mercado', '\App\Gateway\Mercado@status')->name('mercadopago.status');
    Route::get('/razorpay/payment', '\App\Gateway\Razorpay@view')->name('razorpay.view');
    Route::post('/razorpay/status', '\App\Gateway\Razorpay@status');
    Route::get('/payment/flutterwave', '\App\Gateway\Flutterwave@status');
    Route::get('/payment/thawani', '\App\Gateway\Thawani@status');
    Route::get('/payment/instamojo', '\App\Gateway\Instamojo@status');
    Route::get('/payment/toyyibpay', '\App\Gateway\Toyyibpay@status');
    Route::get('/manual/payment', '\App\Gateway\CustomGateway@status');
    Route::get('payu/payment', '\App\Gateway\Payu@view')->name('payu.view');
    Route::post('payu/status', '\App\Gateway\Payu@status')->name('payu.status');
});

//**======================== Utility Routes ====================**//

// Route to Clear Cache
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return '<h1>Cache Cleared!</h1> <p>All caches (View, Route, Config) cleared.</p>';
});

// Utility Route: Run Migrations via URL
Route::get('/run-migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return '<h1>Migrations Completed!</h1><pre>' . $output . '</pre><br><a href="/user/dashboard">Go back to Dashboard</a>';
    } catch (\Exception $e) {
        return '<h1>Migration Failed</h1><p>' . $e->getMessage() . '</p>';
    }
});

// Utility Route: Run Seeders (FAQs) via URL
Route::get('/run-seed', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'FaqSeeder', '--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return '<h1>Seeding Completed!</h1><pre>' . $output . '</pre><br><a href="/user/dashboard">Go back to Dashboard</a>';
    } catch (\Exception $e) {
        return '<h1>Seeding Failed</h1><p>' . $e->getMessage() . '</p>';
    }
});

// Utility Route: Clear All Cache
Route::get('/clear-all-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return '<h1>All Cache Cleared</h1><p>The system has been optimized.</p><br><a href="/user/dashboard">Go back to Dashboard</a>';
});

Route::get('/how-to-fix-redirects', function () {
    return view('frontend.index_v2', ['brands' => collect([]), 'testimonials' => collect([]), 'faqs' => collect([]), 'plans' => collect([]), 'brand_area' => 'active', 'banner' => (object) [], 'features' => collect([]), 'about' => (object) [], 'overview' => (object) [], 'work' => (object) [], 'download' => (object) []]);
});
