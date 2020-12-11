<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day1;

require_once __DIR__ . '/../vendor/autoload.php';

function solve(array $puzzle, int $combination_size): int
{
    return array_product(
        array_first(
            haystack: array_combinations(
                haystack: $puzzle,
                dimensions: $combination_size
            ),
            callback: fn(array $values) => array_sum($values) === 2020
        )
    );
}
