<?php

namespace App\Support\PopupBook;

use Native\Mobile\Skia\Scene;

final class Fonts
{
    public static function register(Scene $scene): void
    {
        foreach (['lobster' => 'Lobster-Regular.ttf', 'josefin' => 'JosefinSans-SemiBold.ttf', 'josefin-light' => 'JosefinSans-Regular.ttf'] as $id => $file) {
            $scene->asset($id, file_get_contents(resource_path('fonts/'.$file)), 'font');
        }
    }
}
