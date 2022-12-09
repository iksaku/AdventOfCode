<?php

namespace AdventOfCode2022\Puzzles\Day09;

use UnexpectedValueException;

class Rope
{
    public array $knots = [];

    public function __construct(int $length = 2)
    {
        if ($length < 2) {
            throw new UnexpectedValueException('Rope length must be equal or greater than 2.');
        }

        $lastKnot = null;

        while ($length-- > 0) {
            $knot = new Knot();

            $lastKnot?->linkKnot($knot);
            $lastKnot = $knot;

            $this->knots[] = $knot;
        }
    }

    public function head(): Knot
    {
        return array_value_first($this->knots);
    }

    public function tail(): Knot
    {
        return array_value_last($this->knots);
    }

    public function follow(array $instructions): void
    {
        foreach ($instructions as $instruction) {
            $this->head()->walk(...$instruction);
        }
    }
}
