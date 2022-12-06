<?php

namespace AdventOfCode2020\Puzzles\Day12;

class Waypoint extends Navigator
{
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
