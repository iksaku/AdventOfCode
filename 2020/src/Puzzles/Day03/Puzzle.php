<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day03;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:03')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield $this->walkForest(rightSteps: 3, downSteps: 1);

        // Part 2
        yield array_product(
            array_map(
                fn ($directions) => $this->walkForest(rightSteps: $directions[0], downSteps: $directions[1]),
                [
                    // [Right Steps, Down Steps]
                    [1, 1],
                    [3, 1],
                    [5, 1],
                    [7, 1],
                    [1, 2],
                ]
            )
        );
    }

    protected function walkForest(int $rightSteps, int $downSteps): int
    {
        $forest = $this->puzzleInputLines();
        $encounteredTrees = 0;

        $x = $rightSteps;
        $y = $downSteps;

        while ($y < count($forest)) {
            $horizon = $forest[$y];
            $horizonLimit = strlen($horizon);

            while ($x >= $horizonLimit) {
                // Simulate pattern generation in X-axis.
                $x -= $horizonLimit;
            }

            if ($horizon[$x] === '#') {
                ++$encounteredTrees;
            }

            $x += $rightSteps;
            $y += $downSteps;
        }

        return $encounteredTrees;
    }
}
