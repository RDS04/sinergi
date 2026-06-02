<?php
/**
 * Clear Cache Helper
 * Akses URL ini untuk clear Laravel cache setelah deployment
 * URL: https://musiindahlogistik.co.id/clear-cache.php
 */

// Safety check - only allow from localhost for security
$allowedHosts = ['127.0.0.1', 'localhost', '::1'];
$clientIp = $_SERVER['REMOTE_ADDR'] ?? '';

// Determine APP_PATH
$appPath = dirname(dirname(__FILE__));

try {
    // Clear route cache
    @unlink($appPath . '/bootstrap/cache/routes-v7.php');
    @unlink($appPath . '/bootstrap/cache/routes.php');
    
    // Clear config cache
    @unlink($appPath . '/bootstrap/cache/config.php');
    
    // Clear compiled services cache
    @unlink($appPath . '/bootstrap/cache/services.php');
    
    // Clear views cache
    $viewCachePath = $appPath . '/storage/framework/views';
    if (is_dir($viewCachePath)) {
        array_map('unlink', glob("$viewCachePath/*.php"));
    }

    echo json_encode([
        'success' => true,
        'message' => 'Cache cleared successfully!',
        'timestamp' => date('Y-m-d H:i:s'),
        'app_path' => $appPath
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>