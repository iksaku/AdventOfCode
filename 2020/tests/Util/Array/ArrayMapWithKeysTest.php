<?php

declare(strict_types=1);

uses()->group('array', 'array_map_with_keys');

it('passes key-value pair into a callback', function (array $haystack, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_map_with_keys(
            callback: fn(string $value, string $key) => "{$key}=>{$value}",
            array: $haystack
        )
    );
})->with([
    [
        ['zero', 'one', 'two', 'three'],
        ['0=>zero', '1=>one', '2=>two', '3=>three'],
    ],
]);
