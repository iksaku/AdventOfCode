<?php

declare(strict_types=1);

namespace AdventOfCode2022\Puzzles\Day09;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:09')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield value(function () {
            $rope = new Rope();
            $rope->tail()->enableTracking();

            $rope->follow($this->instructions());

            return iterable_sum_using(
                iterable:  $rope->tail()->tracker,
                callback: fn (array $yPositions) => count($yPositions)
            );
        });

        // Part 2
        yield value(function () {
            $rope = new Rope(length: 10);
            $rope->tail()->enableTracking();

            $rope->follow($this->instructions());

            return iterable_sum_using(
                iterable: $rope->tail()->tracker,
                callback: fn (array $yPositions) => count($yPositions)
            );
        });
    }

    protected function instructions(): array
    {
        static $cache = null;

        return $cache ??= array_map(
            callback: function (string $instruction): array {
                [$xStep, $yStep] = match (substr($instruction, offset: 0, length: 1)) {
                    'U' => [0, 1],
                    'D' => [0, -1],
                    'L' => [-1, 0],
                    'R' => [1, 0],
                };

                $stepTimes = (int) substr($instruction, offset: 1);

                return [$xStep, $yStep, $stepTimes];
            },
            array: $this->puzzleInputLines()
        );
    }
}
