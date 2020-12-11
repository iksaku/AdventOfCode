<?php

declare(strict_types=1);

use function AdventOfCode2020\Day3\bulkSearchForTrees;
use function AdventOfCode2020\Day3\searchForTrees;

require_once __DIR__.'/../../Day 3/util.php';

uses()->group('Day 3');

$example_puzzle = [
    '..##.......',
    '#...#...#..',
    '.#....#..#.',
    '..#.#...#.#',
    '.#...##..#.',
    '..#.##.....',
    '.#.#.#....#',
    '.#........#',
    '#.##...#...',
    '#...##....#',
    '.#..#...#.#',
];

it('can count encountered trees', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 7,
        actual: searchForTrees(
            puzzle: $example_puzzle,
            down_steps: 1,
            right_steps: 3
        )
    );
});

it('can count encountered trees in bulk search', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 336,
        actual: bulkSearchForTrees($example_puzzle)
    );
});
