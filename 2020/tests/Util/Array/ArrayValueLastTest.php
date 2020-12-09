<?php

declare(strict_types=1);

include_once __DIR__ . '/../../../vendor/autoload.php';

uses()->group('array_value_last');

it('can get the last item of an array', function (array $haystack, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_value_last($haystack)
    );
})->with([
    [[1, 2, 3], 3],
    [[3, 2, 1], 1],
    [['a' => 1, 'b' => 2, 'c' => 3], 3],
    [['first', 'second', 'third'], 'third'],
    [[2 => 'third', 1 => 'second', 0 => 'first'], 'first'],
]);
