<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $view = view('frontend.index_v2');
    echo "Frontend Index V2 Path: " . $view->getPath() . "\n";
} catch (\Exception $e) {
    echo "Frontend Index V2 Error: " . $e->getMessage() . "\n";
}

try {
    $viewFaq = view('frontend.faq');
    echo "Frontend FAQ Path: " . $viewFaq->getPath() . "\n";
} catch (\Exception $e) {
    echo "Frontend FAQ Error: " . $e->getMessage() . "\n";
}
