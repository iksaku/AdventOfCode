<?php

declare(strict_types=1);

use function AdventOfCode2020\Day11\canSeeAnOccupiedSeat;
use function AdventOfCode2020\Day11\gameOfSeats;

require_once __DIR__ . '/../../Day 11/util.php';

uses()->group('Day 11');

dataset('seats', [
    [
        'L.LL.LL.LL',
        'LLLLLLL.LL',
        'L.L.L..L..',
        'LLLL.LL.LL',
        'L.LL.LL.LL',
        'L.LLLLL.LL',
        '..L.L.....',
        'LLLLLLLLLL',
        'L.LLLLLL.L',
        'L.LLLLL.LL',
    ],
]);

it('can track chaos and detect stable results', function(string ...$seats) {
    $this->assertEquals(
        expected: 37,
        actual: gameOfSeats($seats)
    );
})->with('seats')->group('no_ray');

it('can ray trace seats', function (array $seats, int $origin_row, int $origin_column, int $result) {
    $seats = array_map('str_split', $seats);

    $seenSeats = 0;

    foreach (array_combinations(range(-1, 1), 2) as $step) {
        [$row_step, $column_step] = $step;

        $seenSeats += (int) canSeeAnOccupiedSeat($seats, $origin_row, $origin_column, $row_step, $column_step);
    }

    $this->assertEquals(
        expected: $result,
        actual: $seenSeats
    );
})->with([
    [
        [
            '.......#.',
            '...#.....',
            '.#.......',
            '.........',
            '..#L....#',
            '....#....',
            '.........',
            '#........',
            '...#.....',
        ],
        4,
        3,
        8,
    ],
    [
        [
            '.............',
            '.L.L.#.#.#.#.',
            '.............',
        ],
        1,
        1,
        0,
    ],
    [
        [
            '.##.##.',
            '#.#.#.#',
            '##...##',
            '...L...',
            '##...##',
            '#.#.#.#',
            '.##.##.',
        ],
        3,
        3,
        0
    ],
])->group('ray');

it('can track chaos and detect stable results while ray tracing seats', function(string ...$seats) {
    $this->assertEquals(
        expected: 26,
        actual: gameOfSeats($seats, true)
    );
})->with('seats')->group('ray');
