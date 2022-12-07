<?php

namespace AdventOfCode2022\Puzzles\Day07;

abstract class FilesystemItem
{
    public function __construct(
        public readonly string $name,
        public readonly ?Directory $parent = null
    )
    {
    }

    public abstract function size(): int;
}
