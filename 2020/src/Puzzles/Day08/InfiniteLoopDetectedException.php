<?php

namespace AdventOfCode2020\Puzzles\Day08;

use RuntimeException;

class InfiniteLoopDetectedException extends RuntimeException
{
    public function __construct(public int $position)
    {
        parent::__construct("Found an execution loop at position {$this->position}.");
    }
}
