<?php
// Simple verifier: scan PHP/HTML files for include/require and local src/href
$root = __DIR__ . '/..';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$files = [];
foreach ($iterator as $file) {
    if (!$file->isFile()) continue;
    $path = $file->getPathname();
    // Skip scanning the tools directory to avoid false-positives from this script's source
    if (stripos($path, DIRECTORY_SEPARATOR . 'tools' . DIRECTORY_SEPARATOR) !== false) continue;
    if (preg_match('/\.(php|html|htm|inc)$/i', $path)) $files[] = $path;
}

$refs = [];
foreach ($files as $f) {
    $content = file_get_contents($f);
    // includes
    if (preg_match_all('/(?:include|include_once|require|require_once)\s*(?:\(?)(["\'])([^"\']+)\1/i', $content, $m)) {
        foreach ($m[2] as $ref) $refs[] = ['type'=>'include','from'=>$f,'target'=>$ref];
    }
    // local src/href
    if (preg_match_all('/(?:src|href)=["\'](?!https?:|\/\/)([^"\']+)["\']/i', $content, $m2)) {
        foreach ($m2[1] as $ref) $refs[] = ['type'=>'link','from'=>$f,'target'=>$ref];
    }
}

$missing = [];
foreach ($refs as $r) {
    $baseDir = dirname($r['from']);
    $target = $r['target'];
    // normalize
    $targetPath = realpath($baseDir . DIRECTORY_SEPARATOR . $target);
    if ($targetPath === false) {
        // try from project root
        $targetPath = realpath($root . DIRECTORY_SEPARATOR . ltrim($target, '/\\'));
    }
    // Skip targets that include PHP short tags or look dynamic (they will be generated at runtime)
    if (strpos($target, '<?') !== false || strpos($target, '<?=') !== false || preg_match('/<\?\s*php/i', $target)) {
        continue;
    }
    // Also skip targets that include unrendered PHP variables (e.g., contains "<?=$")
    if (preg_match('/\$\w+/', $target)) {
        continue;
    }

    if ($targetPath === false) {
        $missing[] = $r;
    }
}

// Output summary
echo "Checked " . count($files) . " files.\n";
echo "References found: " . count($refs) . "\n";
echo "Missing references: " . count($missing) . "\n\n";
if (count($missing)) {
    foreach ($missing as $m) {
        echo strtoupper($m['type']) . " from " . $m['from'] . " -> " . $m['target'] . "\n";
    }
} else {
    echo "No missing references detected.\n";
}

?>