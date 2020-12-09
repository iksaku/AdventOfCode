<?php

include_once __DIR__ . '/util.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo '[Part 1] Your 2-part expense report result is ' . solve($puzzle, 2) . '.' . PHP_EOL;
echo '[Part 2] Your 3-part expense report result is ' . solve($puzzle, 3) . '.' . PHP_EOL;
