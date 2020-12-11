<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day3;

require_once __DIR__ . '/../vendor/autoload.php';

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

        while ($right >= strlen($line)) {
            $right -= $line_length;
        }

        $encountered_trees += (int) ($line[$right] === '#');
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
