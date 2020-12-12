<?php

declare(strict_types=1);

use function AdventOfCode2020\Day11\gameOfSeats;

require_once __DIR__ . '/util.php';

$puzzle = file(__DIR__ . '/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo gameOfSeats($puzzle) . PHP_EOL;

echo gameOfSeats($puzzle, true) . PHP_EOL;
