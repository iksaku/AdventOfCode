<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

function preparePuzzle(array &$puzzle): void
{
    $puzzle = array_map('intval', $puzzle);

    sort($puzzle);
}

function findJoltageDifferences(array $puzzle): array
{
    preparePuzzle($puzzle);

    $puzzle[] = max($puzzle) + 3;

    return array_count_values(
        array_map_with_keys(
            fn(int $current, int $k) => $current - ($puzzle[$k - 1] ?? 0),
            $puzzle
        )
    );
}

function multipliedJoltageDifference(array $puzzle): int
{
    $difference = findJoltageDifferences($puzzle);

    return $difference[1] * $difference[3];
}

function findPossibleCombinations(array $puzzle): int
{
    preparePuzzle($puzzle);

    $combinations = [1];

    foreach ($puzzle as $adapter) {
        $combinations[$adapter] =
            ($combinations[$adapter - 1] ?? 0) +
            ($combinations[$adapter - 2] ?? 0) +
            ($combinations[$adapter - 3] ?? 0);
    }

    return $combinations[array_value_last($puzzle)];
}
