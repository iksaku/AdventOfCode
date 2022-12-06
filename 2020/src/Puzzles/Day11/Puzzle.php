<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day11;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:11')]
class Puzzle extends BasePuzzle
{
    protected const FLOOR = '.';
    protected const EMPTY_SEAT = 'L';
    protected const OCCUPIED_SEAT = '#';

    protected function handle(): Generator
    {
        // Part 1
        yield $this->gameOfSeats();

        // Part 2
        yield $this->gameOfSeats(raytraceSeats: true);
    }

    protected function compiledInput(): array
    {
        static $cache = null;

        return $cache ??= array_map('str_split', $this->puzzleInputLines());
    }

    protected function gameOfSeats(bool $raytraceSeats = false): int
    {
        $airplane = $this->compiledInput();
        $tolerance = $raytraceSeats ? 5 : 4;

        ray()->clearAll();

        do {
            $nextState ??= $airplane;

            foreach ($airplane as $row => $seats) {
                foreach ($seats as $column => $currentSeatState) {
                    if ($currentSeatState === self::FLOOR) {
                        continue;
                    }

                    $currentSeatIsOccupied = $currentSeatState === self::OCCUPIED_SEAT;

                    $occupiedSeatsInVicinity = iterable_count_using(
                        iterable: array_permutations(range(-1, 1), length: 2),
                        callback: function (array $steps) use ($raytraceSeats, $airplane, $row, $column) {
                            if ($steps === [0, 0]) {
                                return false;
                            }

                            [$rowStep, $columnStep] = $steps;

                            if ($raytraceSeats) {
                                return value(function () use ($airplane, $row, $column, $rowStep, $columnStep) {
                                    if ($rowStep === 0 && $columnStep === 0) {
                                        return false;
                                    }

                                    for (
                                        $x = $row + $rowStep, $y = $column + $columnStep;
                                        $x >= 0 && $x < count($airplane) && $y >= 0 && $y < count($airplane[$x]);
                                        $x += $rowStep, $y += $columnStep
                                    ) {
                                        $seatInSight = $airplane[$x][$y];

                                        if ($seatInSight === self::FLOOR) {
                                            continue;
                                        }

                                        return $seatInSight === self::OCCUPIED_SEAT;
                                    }

                                    return false;
                                });
                            }

                            $adjacentSeat = $airplane[$row + $rowStep][$column + $columnStep] ?? null;

                            return $adjacentSeat === self::OCCUPIED_SEAT;
                        }
                    );

                    $nextState[$row][$column] = match (true) {
                        !$currentSeatIsOccupied && $occupiedSeatsInVicinity === 0 => self::OCCUPIED_SEAT,
                        $currentSeatIsOccupied && $occupiedSeatsInVicinity >= $tolerance => self::EMPTY_SEAT,
                        default => $currentSeatState
                    };
                }
            }

            $hasChanged = $airplane !== $nextState;
            $airplane = $nextState;
        } while ($hasChanged);

        return iterable_sum_using(
            $airplane,
            fn (array $seats) => array_count_values($seats)['#'] ?? 0
        );
    }
}
