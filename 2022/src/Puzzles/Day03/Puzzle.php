<?php

declare(strict_types=1);
namespace AdventOfCode2022\Puzzles\Day03;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:03')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield value(function () {
            $sumOfPriorities = 0;

            foreach ($this->puzzleInputLines() as $items) {
                $compartments = array_chunk(str_split($items), strlen($items) / 2);

                $sharedItem = array_value_first(array_intersect(...$compartments));

                $sumOfPriorities += $this->itemPriority($sharedItem);
            }

            return $sumOfPriorities;
        });

        // Part 2
        yield value(function () {
            $sumOfBadgePriorities = 0;

            foreach ($this->puzzleInputLines(chunkLength: 3) as $team) {
                $team = array_map(
                    str_split(...),
                    $team
                );

                $badge = array_value_first(array_intersect(...$team));

                $sumOfBadgePriorities += $this->itemPriority($badge);
            }

            return $sumOfBadgePriorities;
        });
    }

    protected function itemPriority(string $item): int
    {
        $isUpper = $item === strtoupper($item);

        $start = $isUpper
            ? ord('A')
            : ord('a');

        $delta = (ord($item) - $start) + 1;

        if ($isUpper) {
            $delta += 26;
        }

        return $delta;
    }
}
