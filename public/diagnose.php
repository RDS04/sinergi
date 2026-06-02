<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Laravel Routing Diagnostic</h2>";
echo "<pre>";

echo "=== REQUEST INFO ===\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "\n";
echo "PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? 'NOT SET') . "\n";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "\n";

echo "\n=== FILE CHECK ===\n";
echo ".env exists: " . (file_exists(__DIR__ . '/../.env') ? "✓ YES" : "✗ NO") . "\n";
echo "bootstrap/app.php exists: " . (file_exists(__DIR__ . '/../bootstrap/app.php') ? "✓ YES" : "✗ NO") . "\n";
echo "vendor/autoload.php exists: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? "✓ YES" : "✗ NO") . "\n";

if (file_exists(__DIR__ . '/../.env')) {
    echo "\n=== .ENV CONTENT ===\n";
    $env = file_get_contents(__DIR__ . '/../.env');
    $lines = explode("\n", $env);
    foreach ($lines as $line) {
        if (preg_match('/^APP_/', $line)) {
            echo $line . "\n";
        }
    }
}

echo "\n=== LARAVEL BOOTSTRAP ===\n";
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "✓ Autoloader loaded\n";
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "✓ App bootstrapped\n";
    
    $config = $app->make('config');
    echo "APP_URL: " . $config->get('app.url') . "\n";
    echo "APP_ENV: " . $config->get('app.env') . "\n";
    
    echo "\n=== ROUTES (First 10) ===\n";
    $routes = $app->make('router')->getRoutes();
    $count = 0;
    foreach ($routes as $route) {
        if ($count++ >= 10) break;
        echo $route->getMethod()[0] . " " . $route->getUri() . "\n";
    }
    echo "Total routes: " . count($routes) . "\n";
    
} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "</pre>";
?>
