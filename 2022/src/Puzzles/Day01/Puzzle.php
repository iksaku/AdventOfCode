<?php

declare(strict_types=1);
namespace AdventOfCode2022\Puzzles\Day01;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:01')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield max($this->compiledCalories());

        // Part 2
        yield value(function () {
            $top3 = [null, null, null];

            foreach ($this->compiledCalories() as $calories) {
                $top3[] = $calories;
                sort($top3);
                array_shift($top3);
            }

            return array_sum($top3);
        });
    }

    protected function compiledCalories(): array
    {
        static $cache = null;

        $compileCalories = function (): Generator {
            $calories = 0;

            foreach ($this->puzzleLineByLine() as $line) {
                if (filled($line)) {
                    $calories += (int) $line;
                    continue;
                }

                yield $calories;
                $calories = 0;
            }

            yield $calories;
        };

        return $cache ??= iterator_to_array($compileCalories());
    }
}
