<?php

include_once __DIR__.'/../Day 3/util.php';

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

it('can count encountered trees')
    ->group('Day 3')
    ->assertEquals(
        expected: 7,
        actual: searchForTrees(
            puzzle: $example_puzzle,
            down_steps: 1,
            right_steps: 3
        )
    );

it('can count encountered trees in bulk search')
    ->group('Day 3')
    ->assertEquals(
        expected: 336,
        actual: bulkSearchForTrees($example_puzzle)
    );
