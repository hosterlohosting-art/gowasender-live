<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $controller = app(\App\Http\Controllers\Frontend\PricingController::class);
    $response = $controller->index();
    echo "Controller index() executed successfully.\n";

    // Test view rendering
    if ($response instanceof \Illuminate\View\View) {
        $html = $response->render();
        echo "View rendered successfully.\n";
    }
} catch (\Throwable $e) {
    echo "CRASH DETECTED:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
