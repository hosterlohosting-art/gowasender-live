<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$plans = \App\Models\Plan::all();
foreach ($plans as $plan) {
    echo "ID: " . $plan->id . "\n";
    echo "Title: " . $plan->title . "\n";
    echo "Price: " . $plan->price . "\n";
    echo "Days: " . $plan->days . "\n";
    echo "Status: " . $plan->status . "\n";
    echo "Data: " . json_encode($plan->data) . "\n";
    echo "--------------------------\n";
}
