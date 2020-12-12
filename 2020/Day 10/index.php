<?php

declare(strict_types=1);

include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/util.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo 'The multiplied Joltage difference is ' . multipliedJoltageDifference($puzzle) . '.' . PHP_EOL;

echo 'There are ' . findPossibleCombinations($puzzle) . ' possible different combinations.' . PHP_EOL;
