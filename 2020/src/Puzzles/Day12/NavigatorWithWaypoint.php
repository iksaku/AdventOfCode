<?php

namespace AdventOfCode2020\Puzzles\Day12;

class NavigatorWithWaypoint extends Navigator
{
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
