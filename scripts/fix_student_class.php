<?php

$directory = __DIR__ . '/../resources/views';
$count = 0;

function replaceInDirectory($dir, &$count) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir)
    );
    
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $newContent = str_replace('studentClass', 'schoolClass', $content);
            
            if ($content !== $newContent) {
                file_put_contents($file->getPathname(), $newContent);
                $count++;
                echo "✓ Fixed: " . $file->getPathname() . "\n";
            }
        }
    }
}

echo "Replacing studentClass with schoolClass in all view files...\n\n";
replaceInDirectory($directory, $count);
echo "\n✅ Done! Fixed {$count} files.\n";
