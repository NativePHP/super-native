<?php

use Illuminate\Support\Facades\Route;
use Native\Mobile\Edge\BenchmarkComponent;


Route::native('/', \App\NativeComponents\Explore::class)->name('explore');
