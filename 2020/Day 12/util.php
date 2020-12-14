<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day12;

require_once __DIR__.'/../vendor/autoload.php';

class Navigator {
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

class Waypoint extends Navigator {
    public function rotate(string $direction, int $degrees): void
    {
        // Convert Degrees (0°...360°) to Cardinal Direction (North, East, South, West)
        $rotation = (int) ($degrees / 90);

        // Adjust Waypoint coordinates according to the intended rotation direction
        $switchCoordinates = match ($direction) {
            'L' => fn(int $x, int $y) => [-$y, $x],
            'R' => fn(int $x, int $y) => [$y, -$x],
        };

        for (;  $rotation > 0; --$rotation) {
            [$this->x, $this->y] = $switchCoordinates($this->x, $this->y);
        }
    }
}

class ShipWithWaypoint extends Navigator {
    public Navigator $waypoint;

    public function __construct()
    {
        parent::__construct();

        $this->waypoint = new Waypoint(x: 10, y: 1);
    }

    public function execute(string $command, int $parameter): void
    {
        if ($command !== 'F') {
            $this->waypoint->execute($command, $parameter);

            return;
        }

        $this->x += $parameter * $this->waypoint->x;
        $this->y += $parameter * $this->waypoint->y;
    }
}

function manhattanDistance(array $puzzle, bool $useWaypoint = false): int
{
    $navigator = $useWaypoint ? new ShipWithWaypoint() : new Navigator();

    foreach ($puzzle as $instruction) {
        $command = substr($instruction, 0, 1);
        $parameter = (int) substr($instruction, 1);

        $navigator->execute($command, $parameter);
    }

    return abs($navigator->x) + abs($navigator->y);
}
