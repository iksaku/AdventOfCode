<?php

include_once __DIR__ . '/../../../vendor/autoload.php';

uses()->group('array_first');

it('returns first array element passing truth test', function (array $input, Closure $callback, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_first($input, $callback)
    );
})->with([
    [
        'input' => [1, 10, 100],
        'callback' => fn(int $value) => $value < 50,
        'result' => 1,
    ],
    [
        'input' => ['hello', 'world!'],
        'callback' => fn(string $value) => str_contains($value, 'llo'),
        'result' => 'hello',
    ],
]);

it('returns first element from Generator passing truth test', function (Closure $generator, Closure $callback, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_first($generator(), $callback)
    );
})->with([
    [
        'input' => fn() => yield from [1, 10, 100],
        'callback' => fn(int $value) => $value < 50,
        'result' => 1,
    ],
    [
        'input' => fn() => yield from ['hello', 'world!'],
        'callback' => fn(string $value) => str_contains($value, 'llo'),
        'result' => 'hello',
    ],
]);

it('returns default value when no element passes truth test.', function (array $input, mixed $value) {
    $this->assertEquals(
        expected: $value,
        actual: array_first(
            haystack: $input,
            callback: fn() => false,
            default: $value
        )
    );
})->with([
    [
        'input' => [],
        'value' => null,
    ],
    [
        'input' => [],
        'value' => false,
    ],
    [
        'input' => [1, 2, 3],
        'value' => 'Not found.',
    ],
]);
