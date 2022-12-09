<?php

namespace AdventOfCode2022\Puzzles\Day09;

class Knot
{
    public ?array $tracker = null;

    public function __construct(
        public int $x = 0,
        public int $y = 0,
        bool $enableTracking = false,
        public ?Knot $linkedKnot = null
    )
    {
        if ($enableTracking) {
            $this->enableTracking();
        }
    }

    public function linkKnot(Knot $knot): static
    {
        $this->linkedKnot = $knot;

        return $this;
    }

    public function enableTracking(): static
    {
        if (! isset($this->tracker)) {
            $this->tracker = [];

            $this->savePosition();
        }

        return $this;
    }

    protected function savePosition(): void
    {
        if (isset($this->tracker)) {
            $this->tracker[$this->x] ??= [];
            $this->tracker[$this->x][$this->y] = true;
        }
    }

    public function isAdjacent(Knot $knot): bool
    {
        return abs($this->x - $knot->x) <= 1
            && abs($this->y - $knot->y) <= 1;
    }

    public function walk(int $xStep, int $yStep, int $stepTimes = 1): void
    {
        while ($stepTimes-- > 0) {
            $this->x += $xStep;
            $this->y += $yStep;

            $this->savePosition();

            if (isset($this->linkedKnot)) {
                $this->linkedKnot->follow($this);
            }
        }
    }

    public function follow(Knot $other): void
    {
        while (! $this->isAdjacent($other)) {
            $this->walk(
                xStep: $other->x <=> $this->x,
                yStep: $other->y <=> $this->y
            );
        }
    }
}
