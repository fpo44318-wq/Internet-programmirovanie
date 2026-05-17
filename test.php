<?php
$dir = 'media';
echo "Папка есть: " . (is_dir($dir) ? 'да' : 'нет') . "<br>";
if (is_dir($dir)) {
    $files = scandir($dir);
    echo "Файлы: " . implode(', ', array_slice($files, 2));
}