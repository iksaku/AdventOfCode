<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day13;

use AdventOfCode2020\AnswerNotFoundException;
use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:13')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        ray()->clearAll();

        // Part 1
        yield value(function () {
            [$timestamp, $buses] = $this->compiledInput();

            $closestDepartureBus = iterable_reduce(
                iterable: $buses,
                callback: fn (?int $earliestDepartingBus, int $candidateBus) => match (true) {
                    is_null($earliestDepartingBus),
                    $this->nextDeparture($timestamp, $candidateBus) < $this->nextDeparture($timestamp, $earliestDepartingBus)
                        => $candidateBus,

                    default => $earliestDepartingBus
                }
            );

            $closestDepartureTimestamp = $this->nextDeparture($timestamp, $closestDepartureBus);

            return $closestDepartureBus * ($closestDepartureTimestamp - $timestamp);
        });

        // Part 2
        yield value(function () {
            [, $buses] = $this->compiledInput();

            $timestamp = array_value_first($buses);

            $period = $timestamp;

            foreach ($buses as $offset => $id) {
                while (($timestamp + $offset) % $id !== 0) {
                    $timestamp += $period;
                }

                $period = (int) gmp_lcm($period, $id);
            }

            return $timestamp;
        });
    }

    protected function compiledInput(): array
    {
        static $cache = null;

        return $cache ??= value(function () {
            [$timestamp, $buses] = $this->puzzleInputLines();

            $timestamp = (int) $timestamp;

            $buses = array_map(
                callback: 'intval',
                array: array_filter(
                    array: explode(',', $buses),
                    callback: fn (string $id) => is_numeric($id)
                )
            );

            return [$timestamp, $buses];
        });
    }

    protected function nextDeparture(int $now, int $id): int
    {
        return (int) (ceil($now / $id) * $id);
    }
}
