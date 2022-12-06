<?php

namespace AdventOfCode2020\Puzzles\Day08;

class Instruction
{
    protected const ACCUMULATOR = 'acc';
    protected const JUMP = 'jmp';
    protected const NO_OPERATION = 'nop';

    public bool $inverted = false;
    public bool $evaluated = false;

    public function __construct(public string $type, public int $argument)
    {
    }

    public function hasInverse(): bool
    {
        return ! $this->inverted
            && ($this->type === self::JUMP || $this->type === self::NO_OPERATION);
    }

    public function inverse(): ?static
    {
        if ($this->inverted) {
            return null;
        }

        $clone = clone $this;

        $clone->type = match ($clone->type) {
            self::JUMP => self::NO_OPERATION,
            self::NO_OPERATION => self::JUMP,
            default => $clone->type,
        };

        $clone->evaluated = false;
        $clone->inverted = true;

        return $clone;
    }

    public function evaluate(Sandbox $sandbox): void
    {
        if ($this->evaluated) {
            throw new InfiniteLoopDetectedException($sandbox->position);
        }

        $this->evaluated = true;

        if ($this->type === self::JUMP) {
            $sandbox->position += $this->argument;

            return;
        }

        if ($this->type === self::ACCUMULATOR) {
            $sandbox->accumulator += $this->argument;
        }

        // Executed for acc and nop.
        ++$sandbox->position;
    }

    public function toArray(): array
    {
        return [
            'id' => spl_object_id($this),
            'type' => $this->type,
            'argument' => $this->argument,
            'inverted' => $this->inverted,
            'evaluated' => $this->evaluated,
        ];
    }
}
