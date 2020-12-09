<?php

include_once __DIR__ . '/../Day 1/util.php';

$example_puzzle = [
    '1721',
    '979',
    '366',
    '299',
    '675',
    '1456',
];

it('solves part 1 example')
    ->group('Day 1')
    ->assertEquals(
        expected: 514579,
        actual: solve(
            $example_puzzle,
            combination_size: 2
        )
    );

it('solves part 2 example')
    ->group('Day 1')
    ->assertEquals(
        expected: 241861950,
        actual: solve(
            $example_puzzle,
            combination_size: 3
        )
    );
