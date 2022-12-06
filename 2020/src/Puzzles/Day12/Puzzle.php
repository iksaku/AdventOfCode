<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day12;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:12')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield $this->manhattanDistance();

        // Part 2
        yield $this->manhattanDistance(useWaypoint: true);
    }

    protected function manhattanDistance(bool $useWaypoint = false): int
    {
        $navigator = $useWaypoint ? new NavigatorWithWaypoint() : new Navigator();

        foreach ($this->puzzleInputLines() as $instruction) {
            $command = substr($instruction, offset: 0, length: 1);
            $argument = (int) substr($instruction, offset:1);

            $navigator->execute($command, $argument);
        }

        return abs($navigator->x) + abs($navigator->y);
    }
}
