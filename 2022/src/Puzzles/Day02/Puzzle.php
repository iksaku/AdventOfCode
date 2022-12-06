<?php

declare(strict_types=1);
namespace AdventOfCode2022\Puzzles\Day02;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:02')]
class Puzzle extends BasePuzzle
{
    protected const LOST = 0;
    protected const DRAW = 3;
    protected const WIN = 6;

    protected const ROCK = 'rock';
    protected const PAPER = 'paper';
    protected const SCISSORS = 'scissors';

    protected const MOVE_SCORE = [
        self::ROCK => 1,
        self::PAPER => 2,
        self::SCISSORS => 3,
    ];

    /** @var array<string, Choice> */
    protected const OPPONENT_STRATEGY = [
        'A' => Choice::ROCK,
        'B' => Choice::PAPER,
        'C' => Choice::SCISSORS,
    ];

    protected function handle(): Generator
    {
        // Part 1
        yield iterable_sum_using(
            iterable: $this->puzzleInputLines(),
            callback: function (string $turn) {
                /** @var array<string, Choice> $myStrategy */
                $myStrategy = [
                    'X' => Choice::ROCK,
                    'Y' => Choice::PAPER,
                    'Z' => Choice::SCISSORS,
                ];

                [$opponentMove, $myMove] = explode(' ', $turn);

                $opponentMove = self::OPPONENT_STRATEGY[$opponentMove];
                $myMove = $myStrategy[$myMove];

                return $myMove->score() + $myMove->duel($opponentMove)->value;
            }
        );

        // Part 2
        yield iterable_sum_using(
            iterable: $this->puzzleInputLines(),
            callback: function (string $turn) {
                /** @var array<string, Outcome> $resultStrategy */
                $resultStrategy = [
                    'X' => Outcome::LOST,
                    'Y' => Outcome::DRAW,
                    'Z' => Outcome::WIN,
                ];

                [$opponentMove, $desiredResult] = explode(' ', $turn);

                $opponentMove = self::OPPONENT_STRATEGY[$opponentMove];
                $desiredResult = $resultStrategy[$desiredResult];

                $myMove = match ($desiredResult) {
                    Outcome::DRAW => $opponentMove,

                    Outcome::LOST => $opponentMove->forte(),

                    Outcome::WIN => $opponentMove->weakness(),
                };

                return $myMove->score() + $desiredResult->value;
            }
        );
    }
}
