<?php

declare(strict_types=1);

include_once __DIR__ . '/../../../vendor/autoload.php';

uses()->group('array_wrap');

it('wraps non-array values in an array', function (mixed $value) {
    $this->assertEquals(
        expected: [$value],
        actual: array_wrap($value)
    );
})->with([
    1, -1, 1.0, 'hello', (object) ['foo' => 'bar']
]);

it('doesn\'t wrap array items in another array', function (array $value) {
    $this->assertEquals(
        expected: $value,
        actual: array_wrap($value)
    );
})->with([
    [['Item 1', 'Item 2']],
    [['foo' => 'bar']],
]);
