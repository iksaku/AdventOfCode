<?php

namespace AdventOfCode2020;

use RuntimeException;

class AnswerNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Answer not found for Puzzle.");
    }
}
