<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day5;

require_once __DIR__ . '/../vendor/autoload.php';

function sliceRange(string $direction, array &$range): bool
{
    [$min, $max] = $range;

    $range = match ($direction) {
        'F', 'L' => [$min, (int) floor(($min + $max) / 2)],
        'B', 'R' => [(int) floor(($min + $max) / 2) + 1, $max],
    };

    return true;
}

function findSeat(string $partition): int
{
    $row_range = [0, 127];
    $column_range = [0, 7];

    foreach (str_split($partition) as $direction) {
        match ($direction) {
            'F', 'B' => sliceRange($direction, $row_range),
            'L', 'R' => sliceRange($direction, $column_range),
        };
    }

    [$row] = $row_range;
    [$column] = $column_range;

    return ($row * 8) + $column;
}
