<?php

namespace AdventOfCode2022\Puzzles\Day07;

use Generator;

class Directory extends FilesystemItem
{
    /** @var array<string, FilesystemItem> */
    public array $contents = [];

    public function __construct(
        string     $name,
        ?Directory $parent = null
    )
    {
        parent::__construct($name, $parent);
    }

    public function size(): int
    {
        return iterable_sum_using(
            iterable: $this->contents,
            callback: fn(FilesystemItem $item) => $item->size()
        );
    }

    public function exists(string $path): bool
    {
        return isset($this->contents[$path]);
    }

    public function get(string $path): ?FilesystemItem
    {
        return $this->contents[$path];
    }

    public function append(FilesystemItem $item): void
    {
        $this->contents[$item->name] = $item;
    }

    public function recursiveIterator(): Generator
    {
        foreach ($this->contents as $item) {
            yield $item->name => $item;

            if ($item instanceof Directory) {
                yield from $item->recursiveIterator();
            }
        }
    }
}
