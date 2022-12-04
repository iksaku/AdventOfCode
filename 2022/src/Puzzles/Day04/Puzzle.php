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
        yield value(function () {
            $fullyOverlapCount = 0;

            foreach ($this->puzzleInputLines() as $pair) {
                [$first, $second] = array_map(
                    fn (string $range) => range(...explode('-', $range, limit: 2)),
                    explode(',', $pair)
                );

                $overlaps = count(array_intersect($first, $second));

                if (count($first) === $overlaps || count($second) === $overlaps) {
                    ++$fullyOverlapCount;
                }
            }

            return $fullyOverlapCount;
        });

        // Part 2
        yield value(function () {
            $overlapCount = 0;

            foreach ($this->puzzleInputLines() as $pair) {
                [$first, $second] = array_map(
                    fn (string $range) => range(...explode('-', $range, limit: 2)),
                    explode(',', $pair)
                );

                $overlaps = count(array_intersect($first, $second));

                if ($overlaps > 0) {
                    ++$overlapCount;
                }
            }

            return $overlapCount;
        });
    }
}
