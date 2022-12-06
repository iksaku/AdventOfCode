<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day06;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:06')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield iterable_sum_using(
            iterable: $this->compileGroups(),
            callback: fn (array $group) => count(array_unique(array_merge(...$group)))
        );

        // Part 2
        yield iterable_sum_using(
            iterable: $this->compileGroups(),
            callback: fn (array $group) => count(array_filter(
                array: array_count_values(array_merge(...$group)),
                callback: fn (int $times) => $times === count($group)
            ))
        );
    }

    protected function compileGroups(): Generator
    {
        $group = [];

        foreach ($this->puzzleInputLines() as $line) {
            if (filled($line)) {
                $group[] = str_split($line);
                continue;
            }

            yield $group;
            $group = [];
        }

        yield $group;
    }
}
