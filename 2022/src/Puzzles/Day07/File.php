<?php

namespace AdventOfCode2022\Puzzles\Day07;

class File extends FilesystemItem
{
    public function __construct(
        string $name,
        protected int $size,
        ?Directory $parent = null
    )
    {
        parent::__construct($name, $parent);
    }

    public function size(): int
    {
        return $this->size;
    }
}
