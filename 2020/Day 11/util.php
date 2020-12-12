<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day11;

require_once __DIR__ . '/../vendor/autoload.php';

function canSeeAnOccupiedSeat(array $seats, int $origin_row, int $origin_column, int $row_step, int $column_step): bool
{
    if ($row_step === 0 && $column_step === 0) return false;

    for (
        $row = $origin_row + $row_step, $column = $origin_column + $column_step;
        $row >= 0 && $row < count($seats) && $column >= 0 && $column < count($seats[$row]);
        $row += $row_step, $column += $column_step
    ) {
        $seatInSight = $seats[$row][$column];

        if ($seatInSight === '.') continue;

        return $seatInSight === '#';
    }

    return false;
}

function gameOfSeats(array $seats, bool $rayTraceSeats = false): int
{
    $seats = array_map('str_split', $seats);
    $occupiedTolerance = $rayTraceSeats ? 5 : 4;

    do {
        $nextState = $seats;

        foreach ($seats as $seat_row => $seats_in_row) {
            foreach ($seats_in_row as $seat_column => $currentSeat) {
                // Skip empty seats
                if ($currentSeat === '.') continue;

                $isOccupied = $currentSeat === '#';

                $occupiedSeats = 0;

                foreach (array_combinations(range(-1, 1), 2) as $step) {
                    if ($step === [0, 0]) continue;

                    [$row_step, $column_step] = $step;

                    if ($rayTraceSeats) {
                        $occupiedSeats +=
                            (int) canSeeAnOccupiedSeat($seats, $seat_row, $seat_column, $row_step, $column_step);

                        continue;
                    }

                    $adjacent_seat = $seats[$seat_row + $row_step][$seat_column + $column_step] ?? null;

                    $occupiedSeats += (int) ($adjacent_seat === '#');
                }

                $nextState[$seat_row][$seat_column] = match(true) {
                    !$isOccupied && $occupiedSeats === 0 => '#',
                    $isOccupied && $occupiedSeats >= $occupiedTolerance => 'L',
                    default => $currentSeat
                };
            }
        }

        $hasChanged = $seats !== $nextState;

        $seats = $nextState;
    } while ($hasChanged);

    return array_sum(
        array_map(
            fn(array $seats) => array_count_values($seats)['#'] ?? 0,
            $seats
        )
    );
}
