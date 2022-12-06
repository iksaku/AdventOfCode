<?php

namespace AdventOfCode2022;

use RuntimeException;

class AnswerNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Answer not found for Puzzle.');
    }
}
