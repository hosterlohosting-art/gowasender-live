<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// FREE FOREVER
$free = \App\Models\Plan::find(1);
if ($free) {
    $free->title = 'FREE FOREVER (The "Risk" Plan)';
    $free->price = 0;
    $free->days = 3650; // Long enough
    $free->data = array_merge((array) $free->data, ['messages_limit' => 50]);
    $free->save();
}

// STARTER
$starter = \App\Models\Plan::find(3); // Based on previous list_plans.php ID 3 was Basic
if ($starter) {
    $starter->title = 'STARTER';
    $starter->price = 19;
    $starter->days = 30;
    $starter->save();
}

// PRO DEAL
$pro = \App\Models\Plan::find(4); // Based on previous list_plans.php ID 4 was Amazing
if ($pro) {
    $pro->title = 'PRO DEAL';
    $pro->price = 99;
    $pro->days = 730; // 2 Years
    $pro->is_recommended = 1;
    $pro->save();
}

// RESELLER
$reseller = \App\Models\Plan::find(2); // Based on previous list_plans.php ID 2 was Enterprise
if ($reseller) {
    $reseller->title = 'RESELLER';
    $reseller->price = 2999;
    $reseller->days = 36500; // Lifetime
    $reseller->save();
}

echo "Plans updated successfully.\n";
