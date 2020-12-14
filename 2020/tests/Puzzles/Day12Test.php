<?php

declare(strict_types=1);

use function AdventOfCode2020\Day12\manhattanDistance;

require_once __DIR__ . '/../../Day 12/util.php';

uses()->group('Day 12');

$example_puzzle = [
    'F10',
    'N3',
    'F7',
    'R90',
    'F11',
];

it('moves ship', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 25,
        actual: manhattanDistance($example_puzzle)
    );
});

it('moves ship using waypoint system', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 286,
        actual: manhattanDistance(
            $example_puzzle,
            useWaypoint: true
        )
    );
});
