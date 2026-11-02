<?php

require dirname(__DIR__, 2).'/vendor/autoload.php';
require dirname(__DIR__, 2).'/bootstrap/app.php';

use App\Support\Skia\Commercial;
use App\Support\Skia\Gallery;
use App\Support\Skia\Showcase;

$destination = $argv[1];
if (! is_dir($destination)) {
    mkdir($destination, 0755, true);
}
foreach (Gallery::CHAPTERS as $index => $chapter) {
    file_put_contents($destination.'/'.$index.'.json', Gallery::scene($index)->toJson());
}

foreach (Commercial::DEMOS as $index => $demo) {
    file_put_contents($destination.'/commercial-'.$index.'.json', Commercial::scene($index)->toJson());
}
foreach (Showcase::EXHIBITS as $index => $exhibit) {
    file_put_contents($destination.'/showcase-'.$index.'.json', Showcase::scene($index)->toJson());
}
