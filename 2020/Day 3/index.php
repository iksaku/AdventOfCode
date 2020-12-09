<?php

declare(strict_types=1);

require_once __DIR__.'/util.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo '[Down 1, Right 3] Encountered trees: ' . searchForTrees($puzzle, down_steps: 1, right_steps: 3) . '.' . PHP_EOL;
echo 'Total encountered trees (multiplied): ' . bulkSearchForTrees($puzzle) . '.' . PHP_EOL;
