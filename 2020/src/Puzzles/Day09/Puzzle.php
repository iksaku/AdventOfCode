<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day09;

use AdventOfCode2020\AnswerNotFoundException;
use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:09')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        $preamble = $this->inExampleMode() ? 5 : 25;

        // Part 1
        [$invalidPosition, $invalidNumber] = $this->findInvalid($preamble);
        yield $invalidNumber;

        // Part 2
        yield $this->findWeakness($invalidPosition, $invalidNumber);
    }

    protected function findInvalid(int $preamble): array
    {
        $input = $this->puzzleInputLines();

        for ($mainPosition = $preamble; $mainPosition < count($input); ++$mainPosition) {
            $mainValue = (int) $input[$mainPosition];

            for ($tailSubPosition = $mainPosition - $preamble; $tailSubPosition < $mainPosition - 1; ++$tailSubPosition) {
                $tailSubValue = (int) $input[$tailSubPosition];

                for ($headSubPosition = $tailSubPosition + 1; $headSubPosition < $mainPosition; ++$headSubPosition) {
                    $headSubValue = (int) $input[$headSubPosition];

                    if ($tailSubValue + $headSubValue === $mainValue) {
                        continue 3;
                    }
                }
            }

            return [$mainPosition, $mainValue];
        }

        throw new AnswerNotFoundException(part: 1);
    }

    protected function findWeakness(int $position, int $invalidNumber): int
    {
        $input = array_slice($this->puzzleInputLines(), offset: 0, length: $position, preserve_keys: true);

        $set = [
            (int) array_shift($input)
        ];

        while (count($input) > 0) {
            $set[] = (int) array_shift($input);

            while (($sum = array_sum($set)) > $invalidNumber) {
                array_shift($set);
            }

            if ($sum === $invalidNumber) {
                return min($set) + max($set);
            }
        }

        throw new AnswerNotFoundException(part: 2);
    }
}
