<?php
/**
 * LIVE DATABASE UPDATE SCRIPT
 * Upload this to your public/ folder on gowasender.com
 * Access via: gowasender.com/live_update_plans.php
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Plan;

try {
    // 1. FREE FOREVER
    $free = Plan::find(1);
    if ($free) {
        $free->title = 'FREE FOREVER (The "Risk" Plan)';
        $free->price = 0;
        $free->days = 3650;
        $free->data = array_merge((array) $free->data, ['messages_limit' => 50]);
        $free->save();
        echo "✅ Plan 1 (Free) updated.<br>";
    }

    // 2. STARTER
    $starter = Plan::find(3);
    if ($starter) {
        $starter->title = 'STARTER';
        $starter->price = 19;
        $starter->days = 30;
        $starter->save();
        echo "✅ Plan 3 (Starter) updated.<br>";
    }

    // 3. PRO DEAL
    $pro = Plan::find(4);
    if ($pro) {
        $pro->title = 'PRO DEAL';
        $pro->price = 99;
        $pro->days = 730;
        $pro->is_recommended = 1;
        $pro->save();
        echo "✅ Plan 4 (Pro) updated.<br>";
    }

    // 4. RESELLER
    $reseller = Plan::find(2);
    if ($reseller) {
        $reseller->title = 'RESELLER';
        $reseller->price = 2999;
        $reseller->days = 36500;
        $reseller->save();
        echo "✅ Plan 2 (Reseller) updated.<br>";
    }

    // Clear Caches
    \Artisan::call('view:clear');
    \Artisan::call('cache:clear');
    echo "🚀 Caches cleared. All changes are live!";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
