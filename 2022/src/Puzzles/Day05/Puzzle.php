<?php

declare(strict_types=1);

namespace AdventOfCode2022\Puzzles\Day05;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:05')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        [$stacks, $instructions] = $this->compileProcedure();

        // Part 1
        yield value(function () use ($stacks, $instructions) {
            foreach ($instructions as [$amount, $from, $to]) {
                // Pop N items, in reverse order simulating popping one by one
                $containers = array_reverse(array_splice($stacks[$from], -$amount));

                $stacks[$to] = [...$stacks[$to], ...$containers];
            }

            return join(
                '',
                array: array_map(
                    fn (array $stack) => array_pop($stack),
                    $stacks
                )
            );
        });

        // Part 2
        yield value(function () use ($stacks, $instructions) {
            foreach ($instructions as [$amount, $from, $to]) {
                // Pop N items, in the same order
                $containers = array_splice($stacks[$from], -$amount);

                $stacks[$to] = [...$stacks[$to], ...$containers];
            }

            return join(
                '',
                array: array_map(
                    fn (array $stack) => array_pop($stack),
                    $stacks
                )
            );
        });
    }

    public function compileProcedure(): array
    {
        [$stacks, $instructions] = explode("\n\n", $this->puzzleInput());

        $stacks = preg_replace('/(] | \[)/', '|', $stacks);
        $stacks = preg_replace('/ {4}/', '_|', $stacks);
        $stacks = preg_replace('/ {3}/', '_', $stacks);
        $stacks = str_replace(['[', ']'], '', $stacks);

        $stacks = explode("\n", $stacks);

        // Remove bottom line labeling stack numbers.
        array_pop($stacks);

        $stacks = array_map(
            callback: fn (string $line) => array_map(
                callback: fn (string $container) => match($container) {
                    '_' => null,
                    default => $container
                },
                array: explode('|', $line)
            ),
            array: $stacks
        );

        $stacks = array_map(
            array_filter(...),
            array_rotate_right($stacks)
        );

        $instructions = array_map(
            callback: function (string $instruction) {
                preg_match('/^move (\d+) from (\d+) to (\d+)$/', $instruction, $matches);

                [, $amount, $from, $to] = $matches;

                // Consider stacks using zero-base indexes
                return [(int) $amount, ((int) $from) - 1, ((int) $to) - 1];
            },
            array: explode(PHP_EOL, $instructions)
        );

        return [$stacks, $instructions];
    }
}
