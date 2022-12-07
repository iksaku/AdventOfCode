<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day15;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:15')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        ray()->clearAll();

        // Part 1
        yield $this->playGame(untilTurn: 2020);

        // Part 2
        ini_set('memory_limit', '512M');
        yield $this->playGame(untilTurn: 30000000);
    }

    protected function playGame(int $untilTurn): int
    {
        static $input = null;

        $input ??= explode(
            separator: ',',
            string: array_value_first($this->puzzleInputLines())
        );

        // Taking the form [number => last2Turns]
        $memory = array_map(
            callback: fn (int $turn) => $turn + 1,
            array: array_flip($input),
        );

        $lastSpokenNumber = 0;

        for ($turn = count($memory) + 1; $turn < $untilTurn; ++$turn) {
            $diff = $turn - ($memory[$lastSpokenNumber] ?? $turn);

            $memory[$lastSpokenNumber] = $turn;

            $lastSpokenNumber = $diff;
        }

        return $lastSpokenNumber;
    }
}
