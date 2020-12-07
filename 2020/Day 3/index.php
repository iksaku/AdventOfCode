<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$encountered_trees = 0;

function searchForTrees (int $down_steps, int $right_steps): int
{
    global $puzzle;

    $encountered_trees = 0;

    for (
        $down = $down_steps, $right = $right_steps;
        $down < count($puzzle);
        $down += $down_steps, $right += $right_steps
    ) {
        $line = $puzzle[$down];
        $line_length = strlen($line);

        if ($right >= $line_length) {
            $tail = $right % $line_length === 0 ? 1 : 0;

            $line = str_repeat($line, ceil($right / $line_length) + $tail);
        }

        $encountered_trees += $line[$right] === '#' ? 1 : 0;
    }

    echo "[Down: {$down_steps}, Right: {$right_steps}] Encountered {$encountered_trees} trees." . PHP_EOL;

    return $encountered_trees;
}

$multiplied_total = searchForTrees(down_steps: 1, right_steps: 1)
    * searchForTrees(down_steps: 1, right_steps: 3)
    * searchForTrees(down_steps: 1, right_steps: 5)
    * searchForTrees(down_steps: 1, right_steps: 7)
    * searchForTrees(down_steps: 2, right_steps: 1);

echo "Total encountered trees (multiplied): {$multiplied_total}." . PHP_EOL;
