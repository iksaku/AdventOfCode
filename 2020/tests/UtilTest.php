<?php

include_once __DIR__ . '/../vendor/autoload.php';

//region 'array_value_first' tests
it('can get the first item of an array', function (array $haystack, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_value_first($haystack)
    );
})->with(fn() => [
    [[1, 2, 3], 1],
    [[3, 2, 1], 3],
    [['a' => 1, 'b' => 2, 'c' => 3], 1],
    [['first', 'second', 'third'], 'first'],
    [[2 => 'third', 1 => 'second', 0 => 'first'], 'third'],
]);
//endregion

//region 'array_value_last' tests
it('can get the last item of an array', function (array $haystack, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_value_last($haystack)
    );
})->with(fn() => [
    [[1, 2, 3], 3],
    [[3, 2, 1], 1],
    [['a' => 1, 'b' => 2, 'c' => 3], 3],
    [['first', 'second', 'third'], 'third'],
    [[2 => 'third', 1 => 'second', 0 => 'first'], 'first'],
]);
//endregion

//region 'value' tests
it('returns non-closure value as is', function (mixed $value) {
    $this->assertEquals(
        expected: $value,
        actual: value($value)
    );
})
    ->with([
        1, -1, 1.0, 'hello', ['world'], (object) ['foo' => 'bar']
    ])
    ->group('value');

it('executes closure and returns its value', function (Closure $closure, mixed $value) {
    $this->assertEquals(
        expected: $value,
        actual: value($closure)
    );
})
    ->with([
        [fn() => 3, 3],
        [fn() => 'hello', 'hello']
    ])
    ->group('value');
//endregion

//region 'array_first' tests
it('returns first array element passing truth test', function (array $input, Closure $callback, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_first($input, $callback)
    );
})
    ->with([
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
    ])
    ->group('array_first');

it('returns first element from Generator passing truth test', function (Closure $generator, Closure $callback, mixed $result) {
    $this->assertEquals(
        expected: $result,
        actual: array_first($generator(), $callback)
    );
})
    ->with([
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
    ])
    ->group('array_first');

it('returns default value when no element passes truth test.', function (array $input, mixed $value) {
    $this->assertEquals(
        expected: $value,
        actual: array_first(
            haystack: $input,
            callback: fn() => false,
            default: $value
        )
    );
})
    ->with([
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
    ])
    ->group('array_first');
//endregion

//region 'array_wrap' tests
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
//endregion

//region 'array_combinations' tests
it('throws an error when trying to combine an empty array', function () {
    $this->expectException(ValueError::class);

    iterator_to_array(array_combinations(
        haystack: [],
        dimensions: 1
    ));
})
    ->group('array_combinations');

it('throws an error when trying to combine an array in less than 1 dimension', function (int $dimension) {
    $this->expectException(ValueError::class);

    iterator_to_array(array_combinations(
        haystack: ['A', 'B', 'C'],
        dimensions: $dimension
    ));
})
    ->with([0, -1, -2])
    ->group('array_combinations');

it('returns the same array when combining in 1 dimension', function (array $input) {
    $this->assertEquals(
        expected: $input,
        actual: iterator_to_array(array_combinations(
            haystack: $input,
            dimensions: 1
        ))
    );
})
    ->with([
        [
            'input' => ['A'],
        ],
        [
            'input' => ['A', 'B'],
        ],
        [
            'input' => ['A', 'B', 'C'],
        ],
    ])
    ->group('array_combinations');

it('can combine an array in N dimensions', function (int $dimensions, array $input, array $output) {
    $this->assertEquals(
        expected: $output,
        actual: iterator_to_array(array_combinations(
            haystack: $input,
            dimensions: $dimensions
        ))
    );
})
    ->with([
        // 2 Dimensions
        [
            'dimensions' => 2,
            'input' => ['A'],
            'output' => [
                ['A', 'A'],
            ],
        ],
        [
            'dimensions' => 2,
            'input' => ['A', 'B'],
            'output' => [
                ['A', 'A'], ['A', 'B'],
                ['B', 'A'], ['B', 'B'],
            ],
        ],
        [
            'dimensions' => 2,
            'input' => ['A', 'B', 'C'],
            'output' => [
                ['A', 'A'], ['A', 'B'], ['A', 'C'],
                ['B', 'A'], ['B', 'B'], ['B', 'C'],
                ['C', 'A'], ['C', 'B'], ['C', 'C'],
            ],
        ],

        // 3 Dimensions
        [
            'dimensions' => 3,
            'input' => ['A'],
            'output' => [
                ['A', 'A', 'A'],
            ],
        ],
        [
            'dimensions' => 3,
            'input' => ['A', 'B'],
            'output' => [
                ['A', 'A', 'A'], ['A', 'A', 'B'],
                ['A', 'B', 'A'], ['A', 'B', 'B'],
                ['B', 'A', 'A'], ['B', 'A', 'B'],
                ['B', 'B', 'A'], ['B', 'B', 'B'],
            ],
        ],
        [
            'dimensions' => 3,
            'input' => ['A', 'B', 'C'],
            'output' => [
                ['A', 'A', 'A'], ['A', 'A', 'B'], ['A', 'A', 'C'],
                ['A', 'B', 'A'], ['A', 'B', 'B'], ['A', 'B', 'C'],
                ['A', 'C', 'A'], ['A', 'C', 'B'], ['A', 'C', 'C'],
                ['B', 'A', 'A'], ['B', 'A', 'B'], ['B', 'A', 'C'],
                ['B', 'B', 'A'], ['B', 'B', 'B'], ['B', 'B', 'C'],
                ['B', 'C', 'A'], ['B', 'C', 'B'], ['B', 'C', 'C'],
                ['C', 'A', 'A'], ['C', 'A', 'B'], ['C', 'A', 'C'],
                ['C', 'B', 'A'], ['C', 'B', 'B'], ['C', 'B', 'C'],
                ['C', 'C', 'A'], ['C', 'C', 'B'], ['C', 'C', 'C'],
            ],
        ],
    ])
    ->group('array_combinations');
//endregion
