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
        yield iterable_sum_using(
            iterable: $this->puzzleInputLines(),
            callback: function (string $items) {
                $compartments = array_chunk(str_split($items), strlen($items) / 2);

                $sharedItem = array_value_first(array_intersect(...$compartments));

                return $this->itemPriority($sharedItem);
            }
        );

        // Part 2
        yield iterable_sum_using(
            iterable: array_chunk($this->puzzleInputLines(), length: 3),
            callback: function (array $team) {
                $team = array_map(
                    str_split(...),
                    $team
                );

                $badge = array_value_first(array_intersect(...$team));

                return $this->itemPriority($badge);
            }
        );
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
