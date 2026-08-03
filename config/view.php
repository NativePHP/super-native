<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Unlike the framework default this does not
    | wrap the path in realpath(), which returns false when the directory is
    | absent and leaves Blade with a null cache path. The NativePHP build
    | excludes storage/framework when it copies the app, so the directory does
    | not exist when composer install boots the app inside the platform build
    | directory. Blade creates the directory itself on first write.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),

];
