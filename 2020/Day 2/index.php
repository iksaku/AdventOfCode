<?php

declare(strict_types=1);

use function AdventOfCode2020\Day2\solveForSledRentalPlace;
use function AdventOfCode2020\Day2\solveForTobogganCorporate;

require_once __DIR__ . '/util.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo '[Part 1] There are ' . solveForSledRentalPlace($puzzle) . ' valid passwords for Sled Rental Place.' . PHP_EOL;
echo '[Part 2] There are ' . solveForTobogganCorporate($puzzle) . ' valid passwords for Toboggan Corporate.' . PHP_EOL;
