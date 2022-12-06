<?php

namespace AdventOfCode2020\Puzzles\Day12;

class Navigator
{
    public const DIRECTION_NORTH = 0;
    public const DIRECTION_EAST = 1;
    public const DIRECTION_SOUTH = 2;
    public const DIRECTION_WEST = 3;

    public int $direction = self::DIRECTION_EAST;

    public function __construct(
        public int $x = 0,
        public int $y = 0,
    ) {}

    public function rotate(string $direction, int $degrees): void
    {
        // Convert Degrees (0°...360°) to Cardinal Direction (North, East, South, West)
        $rotation = (int) ($degrees / 90);

        $rotation *= match ($direction) {
            'L' => -1,
            'R' => 1,
        };

        $this->direction += $rotation;

        // Make sure to stick with only 4 cardinalities
        while ($this->direction < self::DIRECTION_NORTH || $this->direction > self::DIRECTION_WEST) {
            $this->direction += 4 * ($this->direction < self::DIRECTION_NORTH ? 1 : -1);
        }
    }

    public function move(string $direction, int $units): void
    {
        // Forward
        if ($direction === 'F') {
            // Convert Forward instruction into Cardinal instruction.
            $direction = match ($this->direction) {
                self::DIRECTION_NORTH => 'N',
                self::DIRECTION_EAST => 'E',
                self::DIRECTION_SOUTH => 'S',
                self::DIRECTION_WEST => 'W'
            };
        }

        // All cardinal directions
        $axis = match ($direction) {
            'N', 'S' => 'y',
            'E', 'W' => 'x',
        };

        // Advance or Retreat
        $units *= match ($direction) {
            'N', 'E' => 1,
            'S', 'W' => -1,
        };

        $this->{$axis} += $units;
    }

    public function execute(string $command, int $parameter): void
    {
        if ($command === 'L' || $command === 'R') {
            $this->rotate($command, $parameter);

            return;
        }

        $this->move($command, $parameter);
    }
}
