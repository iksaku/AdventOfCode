<?php

declare(strict_types=1);

use function AdventOfCode2020\Day5\findSeat;
use function AdventOfCode2020\Day5\sliceRange;

require_once __DIR__ . '/../../Day 5/util.php';

uses()->group('Day 5');

it('can slice range', function (string $direction, array $range, array $result) {
    sliceRange($direction, $range);

    $this->assertEquals(
        expected: $result,
        actual: $range
    );
})->with([
    ['F', [0, 127], [0, 63]],
    ['B', [0, 127], [64, 127]],
    ['L', [0, 7], [0, 3]],
    ['R', [0, 7], [4, 7]]
]);

it('can find seat id', function (string $partition, int $result) {
    $this->assertEquals(
        expected: $result,
        actual: findSeat($partition)
    );
})->with([
    ['FBFBBFFRLR', 357],
    ['BFFFBBFRRR', 567],
    ['FFFBBBFRRR', 119],
    ['BBFFBBFRLL', 820],
]);
