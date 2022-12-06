<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day02;

use AdventOfCode2020\BasePuzzle;
use Closure;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:02')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield $this->applyPolicy(
            fn($password, $character, $min, $max) =>
            between(substr_count($password, $character), $min, $max)
        );

        // Part 2
        yield $this->applyPolicy(
            fn ($password, $character, $posA, $posB) =>
                // Note: Policy has no zero-index concept
                $password[$posA - 1] === $character xor
                $password[$posB - 1] === $character
        );
    }

    protected function applyPolicy(Closure $callback): int
    {
        return iterable_count_using(
            iterable: $this->puzzleInputLines(),
            callback: function (string $line) use ($callback) {
                [$range, $character, $password] = explode(' ', $line);

                $character = str_replace(':', '', $character);
                [$min, $max] = explode('-', $range);

                return (bool) $callback($password, $character, (int)$min, (int)$max);
            }
        );
    }
}
