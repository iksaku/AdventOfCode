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

    protected const OPPONENT_STRATEGY = [
        'A' => self::ROCK,
        'B' => self::PAPER,
        'C' => self::SCISSORS,
    ];

    protected function handle(): Generator
    {
        // Part 1
        yield value(function () {
            $myStrategy = [
                'X' => self::ROCK,
                'Y' => self::PAPER,
                'Z' => self::SCISSORS,
            ];

            $duel = fn (string $opponent, $me) => match (true) {
                $opponent === self::ROCK && $me === self::SCISSORS,
                    $opponent === self::PAPER && $me === self::ROCK,
                    $opponent === self::SCISSORS && $me === self::PAPER => self::LOST,

                $opponent === $me => self::DRAW,

                default => self::WIN
            };

            $score = 0;

            foreach ($this->puzzleInputLines() as $turn) {
                [$opponentMove, $myMove] = explode(' ', $turn);

                $opponentMove = self::OPPONENT_STRATEGY[$opponentMove];
                $myMove = $myStrategy[$myMove];

                $score += self::MOVE_SCORE[$myMove] + $duel($opponentMove, $myMove);
            }

            return $score;
        });

        // Part 2
        yield value(function () {
            $resultStrategy = [
                'X' => self::LOST,
                'Y' => self::DRAW,
                'Z' => self::WIN,
            ];

            $obtainMoveBasedOnResult = fn (string $opponentMove, int $desiredResult) => match ($desiredResult) {
                self::DRAW => $opponentMove,

                self::LOST => match ($opponentMove) {
                    self::ROCK => self::SCISSORS,
                    self::PAPER => self::ROCK,
                    self::SCISSORS => self::PAPER,
                },

                self::WIN => match ($opponentMove) {
                    self::ROCK => self::PAPER,
                    self::PAPER => self::SCISSORS,
                    self::SCISSORS => self::ROCK,
                },
            };

            $score = 0;

            foreach ($this->puzzleInputLines() as $turn) {
                [$opponentMove, $desiredResult] = explode(' ', $turn);

                $opponentMove = self::OPPONENT_STRATEGY[$opponentMove];
                $desiredResult = $resultStrategy[$desiredResult];

                $myMove = $obtainMoveBasedOnResult($opponentMove, $desiredResult);

                $score += self::MOVE_SCORE[$myMove] + $desiredResult;
            }

            return $score;
        });
    }
}
