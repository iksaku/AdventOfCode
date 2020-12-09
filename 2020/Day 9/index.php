<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function isValid(int $value, int $position): bool
{
    global $puzzle;

    $preamble_start = $position - 25;
    $preamble_end = $position - 1;

    for ($j = $preamble_start; $j <= $preamble_end; ++$j) {
        $j_value = (int) $puzzle[$j];

        for ($k = $preamble_start; $k <= $preamble_end; ++$k) {
            if ($j === $k) continue;

            $k_value = (int) $puzzle[$k];

            // If $current is valid, skip to the next $current value
            if ($j_value + $k_value === $value) return true;
        }
    }

    return false;
}

function searchForWeakness(int $value, int $position): array
{
    global $puzzle;

    $set = [
        (int) $puzzle[0]
    ];

    // Skip first number, save a conditional check running in the loop
    for ($i = 1; $i < $position; ++$i) {
        $set[] = (int) $puzzle[$i];

        while (($sum = array_sum($set)) > $value) {
            array_shift($set);
        }

        if ($sum === $value) return $set;
    }

    return [];
}

// Skip the first preamble of 25 numbers
for ($i = 25; $i < count($puzzle); ++$i) {
    $current = (int) $puzzle[$i];

    if (isValid($current, $i)) continue;

    echo "Found an invalid value: {$current}." . PHP_EOL;

    $weakness_set = searchForWeakness($current, $i);

    if (empty($weakness_set)) {
        echo "Unable to find weakness for '{$current}'." . PHP_EOL;
        exit(1);
    }

    $weakness = min($weakness_set) + max($weakness_set);

    echo "Weakness for '{$current}': {$weakness}." . PHP_EOL;
}
