<?php

use Native\Mobile\Edge\NativeRouter;

it('points every native route at an existing screen component', function () {
    $missing = collect(NativeRouter::registeredRoutes())
        ->reject(fn (array $route): bool => class_exists($route['class']))
        ->map(fn (array $route): string => $route['class'])
        ->all();

    expect($missing)->toBe([]);
});
