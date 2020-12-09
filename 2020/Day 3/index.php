<?php

require_once __DIR__.'/util.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

echo 'Total encountered trees (multiplied): ' . bulkSearchForTrees($puzzle) . '.' . PHP_EOL;
