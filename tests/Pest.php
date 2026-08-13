<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Native\Mobile\Testing\PestExpectations;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

// Native testing suite sugar: expect($screen)->toSee(...)->toBeAccessible() etc.
PestExpectations::register();

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

/**
 * Every node type present in a published wire tree, flattened depth-first.
 *
 * Lives here rather than in one test file because two suites ask the same
 * question of a tree — "is this element type in here at all" — and a helper
 * declared inside a Pest test file is a global function whose availability
 * depends on file load order.
 *
 * @param  array<string, mixed>  $node
 * @param  array<int, string>  $seen
 * @return array<int, string>
 */
function treeTypes(array $node, array &$seen = []): array
{
    $seen[] = $node['type'] ?? '';

    foreach ($node['children'] ?? [] as $child) {
        treeTypes($child, $seen);
    }

    return $seen;
}
