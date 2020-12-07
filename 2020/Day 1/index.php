<?php

declare(strict_types=1);

include_once __DIR__.'/../vendor/autoload.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Part 1: Find 2 pieces that summed up result in '2020'. Store their product.
$two_part_result = null;

// Part 2: Find 3 pieces that summed up result in '2020'. Store their product.
$three_part_result = null;

foreach ($puzzle as $first_piece) {
    foreach ($puzzle as $second_piece) {
        if (!is_null($two_part_result) && !is_null($three_part_result)) {
            break 2;
        }

        if (is_null($three_part_result)) {
            foreach ($puzzle as $third_piece) {
                if (($first_piece + $second_piece + $third_piece) !== 2020) {
                    continue;
                }

                $three_part_result = $first_piece * $second_piece * $third_piece;

                break;
            }
        }

        if (!is_null($two_part_result)) {
            continue;
        }

        if (($first_piece + $second_piece) !== 2020) {
            continue;
        }

        $two_part_result = $first_piece * $second_piece;
    }
}

echo "[Part 1] Your 2-part expense report result is '{$two_part_result}'." . PHP_EOL;
echo "[Part 2] Your 3-part expense report result is '{$three_part_result}'." . PHP_EOL;

