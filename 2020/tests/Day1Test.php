<?php

include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/../Day 1/functions.php';

dataset('example_puzzle', [
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
    ->with('example_puzzle')
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
    ->with('example_puzzle')
    ->group('Day 1');
