<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$primary_data = get_option('primary_data', true);
echo "Favicon Option: " . ($primary_data->favicon ?? 'NOT SET') . "\n";
