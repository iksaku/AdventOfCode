<?php

include_once __DIR__ . '/../vendor/autoload.php';

function solve(array $puzzle, int $combination_size): int
{

    $combinations = array_combinations(
        haystack: $puzzle,
        dimensions: $combination_size
    );

    $product = array_product(
        array_first(
            haystack: $combinations,
            callback: fn(array $values) => array_sum($values) === 2020
        )
    );

    return $product;
}
