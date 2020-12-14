<?php

declare(strict_types=1);

use function AdventOfCode2020\Day12\manhattanDistance;

require_once __DIR__ . '/util.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo "Manhattan Distance from 0,0: " . manhattanDistance($puzzle) . '.' . PHP_EOL;
echo "Manhattan Distance from 0,0 (Using Waypoint): " . manhattanDistance($puzzle, useWaypoint: true) . '.' . PHP_EOL;
