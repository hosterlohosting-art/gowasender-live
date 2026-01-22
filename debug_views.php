<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$view = view('frontend.index');
echo "Frontend Index Path: " . $view->getPath() . "\n";

try {
    $viewPricing = view('frontend.plans');
    echo "Frontend Plans Path: " . $viewPricing->getPath() . "\n";
} catch (\Exception $e) {
    echo "Frontend Plans Error: " . $e->getMessage() . "\n";
}
