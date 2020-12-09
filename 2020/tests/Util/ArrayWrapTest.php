<?php

include_once __DIR__ . '/../../vendor/autoload.php';

it('wraps non-array values in an array', function (mixed $value) {
    $this->assertEquals(
        expected: [$value],
        actual: array_wrap($value)
    );
})
    ->with([
        1, -1, 1.0, 'hello', (object) ['foo' => 'bar']
    ])
    ->group('array_wrap');

it('doesn\'t wrap array items in another array', function (array $value) {
    $this->assertEquals(
        expected: $value,
        actual: array_wrap($value)
    );
})
    ->with([
        [['Item 1', 'Item 2']],
        [['foo' => 'bar']],
    ])
    ->group('array_wrap');
