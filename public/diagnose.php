<?php
echo "<h2>Storage & Symlink Diagnostic</h2><pre>";

// 1. Check symlink
echo "=== SYMLINK ===\n";
$link = __DIR__ . '/storage';
if (is_link($link)) {
    echo "✓ Symlink exists\n";
    echo "Points to: " . readlink($link) . "\n";
} else {
    echo "✗ NO SYMLINK!\n";
}

// 2. Check storage files
echo "\n=== FILES IN storage/app/public/ ===\n";
$storageDir = __DIR__ . '/../storage/app/public/';
if (is_dir($storageDir)) {
    $files = scandir($storageDir);
    $count = 0;
    foreach ($files as $f) {
        if ($f !== '.' && $f !== '..') {
            echo "- $f\n";
            $count++;
        }
    }
    echo "Total: $count files\n";
} else {
    echo "✗ Folder tidak ada!\n";
}

// 3. Test URL access
echo "\n=== TEST IMAGE URLS ===\n";
$testImages = [
    'logo.png',
    'enbi.webp',
    'kartu undangan.png',
    'metamedia.jpg',
    '17 pro.webp',
    'macbook.jpg'
];

foreach ($testImages as $img) {
    $localPath = __DIR__ . '/storage/' . $img;
    $url = '/sinergi/public/storage/' . urlencode($img);
    $exists = file_exists($localPath) ? "✓" : "✗";
    echo "$exists $img → $url\n";
}

echo "</pre>";
?>