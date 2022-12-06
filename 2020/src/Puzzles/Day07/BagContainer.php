<?php

declare(strict_types=1);
namespace AdventOfCode2020\Puzzles\Day07;

class BagContainer
{
    public function __construct(
        public BagType $bag,
        public int $quantity
    ) {}
}
