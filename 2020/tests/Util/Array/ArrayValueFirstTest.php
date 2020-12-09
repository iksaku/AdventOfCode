<?php

declare(strict_types=1);

include_once __DIR__ . '/../../../vendor/autoload.php';

uses()->group('array_value_first');

it('can get the first item of an array', function (array $haystack, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_value_first($haystack)
    );
})->with([
    [[1, 2, 3], 1],
    [[3, 2, 1], 3],
    [['a' => 1, 'b' => 2, 'c' => 3], 1],
    [['first', 'second', 'third'], 'first'],
    [[2 => 'third', 1 => 'second', 0 => 'first'], 'third'],
]);
