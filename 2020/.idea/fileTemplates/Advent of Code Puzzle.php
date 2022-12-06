<?php

declare(strict_types=1);
namespace AdventOfCode2020\Puzzles\Day${PuzzleDay};

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:${PuzzleDay}')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield value(function () {
            // TODO: Implement Part 1 of the Puzzle
        });
        
        // Part 2
        yield value(function () {
            // TODO: Implement Part 2 of the Puzzle
        });
    }
}
