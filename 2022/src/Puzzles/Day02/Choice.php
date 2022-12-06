<?php

namespace AdventOfCode2022\Puzzles\Day02;

enum Choice
{
    case ROCK;
    case PAPER;
    case SCISSORS;

    public function score(): int
    {
        return match ($this) {
            Choice::ROCK => 1,
            Choice::PAPER => 2,
            Choice::SCISSORS => 3
        };
    }

    public function duel(Choice $against): Outcome
    {
        return match (true) {
            $this === $against => Outcome::DRAW,

            $this->weakness() === $against => Outcome::LOST,

            default => Outcome::WIN
        };
    }

    public function weakness(): Choice
    {
        return match ($this) {
            Choice::ROCK => Choice::PAPER,
            Choice::PAPER => Choice::SCISSORS,
            Choice::SCISSORS => Choice::ROCK
        };
    }

    public function forte(): Choice
    {
        return $this->weakness()->weakness();
    }
}
