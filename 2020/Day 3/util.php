<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

function searchForTrees(array $puzzle, int $down_steps, int $right_steps): int
{
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

            $line = str_repeat($line, (int) (ceil($right / $line_length) + $tail));
        }

        $encountered_trees += $line[$right] === '#' ? 1 : 0;
    }

    return $encountered_trees;
}

function bulkSearchForTrees(array $puzzle): int
{
    return array_product(
        array_map(
            callback: fn(array $instruction): int => searchForTrees($puzzle, ...$instruction),
            array: [
                // [down_steps, right_steps]
                [1, 1],
                [1, 3],
                [1, 5],
                [1, 7],
                [2, 1],
            ]
        )
    );
}
