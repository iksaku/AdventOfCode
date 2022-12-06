<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day08;

use AdventOfCode2020\AnswerNotFoundException;
use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:08')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield value(function () {
            $sandbox = new Sandbox();

            try {
                $sandbox->execute($this->compileInstructions());
            } catch (InfiniteLoopDetectedException) {
                return $sandbox->accumulator;
            }

            throw new AnswerNotFoundException(part: 1);
        });

        // Part 2
        yield value(function () {
            $sandbox = new Sandbox();

            $sandbox->lookForInvertedInstruction($this->compileInstructions());

            return $sandbox->accumulator;
        });
    }

    /**
     * @return array<Instruction>
     */
    protected function compileInstructions(): array
    {
        return iterator_to_array(iterable_map(
            iterable: $this->puzzleInputLines(),
            callback: function (string $input) {
                [$type, $argument] = explode(' ', $input);

                return new Instruction($type, (int) $argument);
            }
        ));
    }
}
