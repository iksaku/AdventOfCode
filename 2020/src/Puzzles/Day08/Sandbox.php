<?php

namespace AdventOfCode2020\Puzzles\Day08;

use AdventOfCode2020\AnswerNotFoundException;

class Sandbox
{
    public function __construct(public int $position = 0, public int $accumulator = 0)
    {
    }

    /**
     * @param array<Instruction> $instructions
     * @return void
     */
    public function execute(array $instructions): void
    {
        while (true) {
            $current = $instructions[$this->position] ?? null;

            if (is_null($current)) {
                return;
            }

            $current->evaluate($this);
        }
    }

    /**
     * @param array<Instruction> $instructions
     * @return void
     */
    public function lookForInvertedInstruction(array $instructions): void
    {
        while (true) {
            $current = $instructions[$this->position] ?? null;

            if (is_null($current)) {
                throw new AnswerNotFoundException(part: 2);
            }

            if ($current->hasInverse()) {
                $subSandbox = clone $this;

                $subInstructions = array_deep_clone($instructions);
                $subInstructions[$this->position] = $current->inverse();

                try {
                    $subSandbox->execute($subInstructions);

                    $this->accumulator = $subSandbox->accumulator;

                    return;
                } catch (InfiniteLoopDetectedException) {
                    //
                }
            }

            $current->evaluate($this);
        }
    }
}
