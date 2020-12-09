<?php

declare(strict_types=1);

include_once __DIR__ . '/../../Day 1/util.php';

uses()->group('Day 1');

$example_puzzle = [
    '1721',
    '979',
    '366',
    '299',
    '675',
    '1456',
];

it('solves part 1 example', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 514579,
        actual: solve(
            $example_puzzle,
            combination_size: 2
        )
    );
});

it('solves part 2 example', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 241861950,
        actual: solve(
            $example_puzzle,
            combination_size: 3
        )
    );
});
