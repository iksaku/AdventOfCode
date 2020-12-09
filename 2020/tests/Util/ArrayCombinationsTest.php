<?php

include_once __DIR__ . '/../../vendor/autoload.php';

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
