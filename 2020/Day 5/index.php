<?php

declare(strict_types=1);

use function AdventOfCode2020\Day5\findSeat;

require_once __DIR__ . '/util.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$seats = array_map(
    callback: fn(string $partition) => findSeat($partition),
    array: $puzzle
);

$min = min($seats);
$max = max($seats);

echo "Highest Seat ID is {$max}." . PHP_EOL;

while ($min < $max) {
    if (!in_array($min, $seats)) break;

    ++$min;
}

echo "Your Seat ID is {$min}." . PHP_EOL;
