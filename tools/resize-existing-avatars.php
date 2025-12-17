<?php
// Batch-resize existing avatars in storage/app/public/avatars
// Backup originals to avatars/originals/, produce avatars/<name> (400x400) and avatars/thumbs/<name> (128x128)

require __DIR__ . '/../vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;
use \Exception;

$base = __DIR__ . '/../storage/app/public/avatars';
$backupDir = $base . '/originals';
$thumbDir = $base . '/thumbs';

if (!is_dir($base)) {
    echo "Avatars directory not found: $base\n";
    exit(1);
}

if (!is_dir($backupDir)) mkdir($backupDir, 0755, true);
if (!is_dir($thumbDir)) mkdir($thumbDir, 0755, true);

$files = scandir($base);
$processed = 0;
foreach ($files as $file) {
    if (in_array($file, ['.', '..', 'thumbs', 'originals'])) continue;
    $path = $base . '/' . $file;
    if (!is_file($path)) continue;

    try {
        // Skip already-small files (we still back them up but re-create)
        $info = pathinfo($file);
        $ext = strtolower($info['extension'] ?? 'jpg');
        $name = $info['basename'];

        // backup original
        $backupPath = $backupDir . '/' . $name;
        if (!file_exists($backupPath)) {
            rename($path, $backupPath);
            echo "Backed up original: $name\n";
        } else {
            // original already backed up, overwrite input path by copying backup
            copy($backupPath, $path);
        }

        // produce main 400x400
        $img = Image::make($backupPath)->fit(400, 400)->encode('jpg', 85);
        file_put_contents($base . '/' . $name, (string) $img);

        // produce thumb 128x128
        $thumb = Image::make($backupPath)->fit(128, 128)->encode('jpg', 85);
        file_put_contents($thumbDir . '/' . $name, (string) $thumb);

        echo "Processed: $name\n";
        $processed++;
    } catch (Exception $e) {
        echo "Error processing $file: " . $e->getMessage() . "\n";
    }
}

echo "Done. Processed: $processed files. Originals stored in avatars/originals/. Thumbnails in avatars/thumbs/.\n";

