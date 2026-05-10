<?php
// Simple cache clearing script
$cacheDir = __DIR__ . '/var/cache';

function deleteDir($dir) {
    if (!is_dir($dir)) return true;
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        (is_dir($path)) ? deleteDir($path) : unlink($path);
    }
    return rmdir($dir);
}

if (deleteDir($cacheDir)) {
    echo "✅ Cache cleared successfully!\n";
    // Recreate the directory
    @mkdir($cacheDir, 0755, true);
} else {
    echo "❌ Failed to clear cache\n";
}
?>
