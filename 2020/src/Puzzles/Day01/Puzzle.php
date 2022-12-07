<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day01;

use AdventOfCode2020\AnswerNotFoundException;
use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:01')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield $this->findResult(combinationLength: 2, part: 1);

        // Part 2
        yield $this->findResult(combinationLength: 3, part: 2);
    }

    protected function findResult(int $combinationLength, int $part): int
    {
        foreach (array_combinations($this->puzzleInputLines(), length: $combinationLength) as $combination) {
            if (array_sum($combination) === 2020) {
                return array_product($combination);
            }
        }

        throw new AnswerNotFoundException();
    }
}
