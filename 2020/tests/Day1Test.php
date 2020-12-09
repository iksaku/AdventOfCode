<?php

include_once __DIR__ . '/../Day 1/util.php';

dataset('day_1_example', [
    [
        '1721',
        '979',
        '366',
        '299',
        '675',
        '1456',
    ]
]);

it('solves part 1 example', function (string ...$puzzle) {
    $this->assertEquals(
        expected: 514579,
        actual: solve(
            $puzzle,
            combination_size: 2
        )
    );
})
    ->with('day_1_example')
    ->group('Day 1');

it('solves part 2 example', function (string ...$puzzle) {
    $this->assertEquals(
        expected: 241861950,
        actual: solve(
            $puzzle,
            combination_size: 3
        )
    );
})
    ->with('day_1_example')
    ->group('Day 1');
