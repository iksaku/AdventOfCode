<?php

declare(strict_types=1);

namespace AdventOfCode2022\Puzzles\Day06;

use AdventOfCode2022\AnswerNotFoundException;
use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:06')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield $this->findMarkerPosition(length: 4);

        // Part 2
        yield $this->findMarkerPosition(length: 14);
    }

    protected function findMarkerPosition(int $length): int
    {
        $buffer = str_split($this->puzzleInputLines()[0]);

        for ($i = $length; $i < count($buffer); ++$i) {
            $marker = array_slice($buffer, offset: $i - $length, length: $length);

            if (count(array_unique($marker)) === $length) {
                return $i;
            }
        }

        throw new AnswerNotFoundException();
    }
}
