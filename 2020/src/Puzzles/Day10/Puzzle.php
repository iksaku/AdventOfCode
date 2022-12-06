<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day10;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:10')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield value(function () {
            $differences = value(function () {
                $input = $this->compiledInput();
                $input[] = max($input) + 3;

                return array_count_values(
                    array_map(
                        fn (int $current, int $key) => $current - ($input[$key - 1] ?? 0),
                        $input,
                        array_keys($input)
                    )
                );
            });

            return $differences[1] * $differences[3];
        });

        // Part 2
        yield value(function () {
            $input = $this->compiledInput();

            $combinations = [1];

            foreach ($input as $adapter) {
                $combinations[$adapter] =
                    ($combinations[$adapter - 1] ?? 0) +
                    ($combinations[$adapter - 2] ?? 0) +
                    ($combinations[$adapter - 3] ?? 0);
            }

            return $combinations[array_value_last($input)];
        });
    }

    protected function compiledInput(): array
    {
        static $cache = null;

        return $cache ??= value(function () {
            $input = array_map('intval', $this->puzzleInputLines());

            sort($input);

            return $input;
        });
    }
}
