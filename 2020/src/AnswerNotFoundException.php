<?php

namespace AdventOfCode2020;

use RuntimeException;

class AnswerNotFoundException extends RuntimeException
{
    public function __construct(int $part)
    {
        parent::__construct("Answer not found for Puzzle Part #1");
    }
}
