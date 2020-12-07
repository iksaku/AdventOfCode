<?php

declare(strict_types=1);

include_once __DIR__.'/../vendor/autoload.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function sliceRange(string $direction, array &$range): bool
{
    [$min, $max] = $range;

    $range = match($direction) {
        'F', 'L' => [$min, floor(($min + $max) / 2)],
        'B', 'R' => [floor(($min + $max) / 2) + 1, $max]
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
            'L', 'R' => sliceRange($direction, $column_range)
        };
    }

    [$row] = $row_range;
    [$column] = $column_range;

    return ($row * 8) + $column;
}

$seats = [];

foreach ($puzzle as $partition) {
    $seats[] = findSeat($partition);
}

sort($seats);

$min = $seats[0];
$max = $seats[array_key_last($seats)];

echo "Highest Seat ID is {$max}." . PHP_EOL;

for (; $min <= $max; ++$min) {
    if (in_array($min, $seats)) continue;

    echo "Your Seat ID is {$min}." . PHP_EOL;
    break;
}
