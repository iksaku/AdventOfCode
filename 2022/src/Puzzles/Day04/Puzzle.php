<?php

declare(strict_types=1);

namespace AdventOfCode2022\Puzzles\Day04;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:04')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield iterable_count_using(
            iterable: $this->compiledAssignments(),
            callback: function (array $pair): bool {
                [$first, $second] = $pair;

                $overlaps = count(array_intersect($first, $second));

                return count($first) === $overlaps || count($second) === $overlaps;
            }
        );

        // Part 2
        yield iterable_count_using(
            iterable: $this->compiledAssignments(),
            callback: function (array $pair): bool {
                [$first, $second] = $pair;

                $overlaps = count(array_intersect($first, $second));

                return $overlaps > 0;
            }
        );
    }

    protected function compiledAssignments(): array
    {
        static $cache = null;

        return $cache ??= array_map(
            callback: fn (string $pair) => array_map(
                // 2. Parse ranges
                callback: fn (string $range) => range(...explode('-', $range, limit: 2)),
                // 1. Split pairs.
                array: explode(',', $pair)
            ),
            array: $this->puzzleInputLines()
        );
    }
}
