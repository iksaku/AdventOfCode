<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day05;

use AdventOfCode2020\AnswerNotFoundException;
use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:05')]
class Puzzle extends BasePuzzle
{
    protected const FRONT = 'F';
    protected const BACK = 'B';
    protected const LEFT = 'L';
    protected const RIGHT = 'R';

    protected function handle(): Generator
    {
        $seats = array_map(
            [$this, 'getSeatId'],
            $this->puzzleInputLines()
        );

        $min = min($seats);
        $max = max($seats);

        // Part 1
        yield $max;

        // Part 2
        yield value(function () use ($seats, $min, $max) {
            while ($min < $max) {
                if (! in_array($min, $seats)) {
                    return $min;
                }

                ++$min;
            }

            throw new AnswerNotFoundException(part: 2);
        });
    }

    protected function getSeatId(string $partition): int
    {
        $rowRange = [0, 127];
        $columnRange = [0, 7];

        $sliceRange = function (string $direction, array &$range) {
            [$min, $max] = $range;

            $slice = fn () => (int) floor(($min + $max) / 2);

            $range = match ($direction) {
                self::FRONT, self::LEFT => [$min, $slice()],
                self::BACK, self::RIGHT => [$slice() + 1, $max],
            };
        };

        foreach (str_split($partition) as $direction) {
            match ($direction) {
                self::FRONT, self::BACK => $sliceRange($direction, $rowRange),
                self::LEFT, self::RIGHT => $sliceRange($direction, $columnRange),
            };
        }

        [$row] = $rowRange;
        [$column] = $columnRange;

        return ($row * 8) + $column;
    }
}
