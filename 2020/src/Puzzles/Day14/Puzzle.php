<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day14;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;
use UnexpectedValueException;

#[AsCommand(name: 'day:14')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        ray()->clearAll();

        // Part 1
        yield value(function () {
            $memory = [];

            $mask = null;

            foreach ($this->puzzleInputLines() as $instruction) {
                if (str_starts_with($instruction, 'mask')) {
                    $mask = array_map(
                        callback: 'intval',
                        array: array_filter(
                            array: str_split(
                                substr($instruction, offset: -36)
                            ),
                            callback: 'is_numeric'
                        )
                    );

                    continue;
                }

                preg_match('/^\D*\[(\d+)\]\D*(\d+)$/', $instruction, $matches);

                [, $address, $value] = $matches;

                $value = join(
                    separator: '',
                    array: array_replace(
                        str_split(
                            str_pad(
                                decbin((int) $value),
                                length: 36,
                                pad_string: '0',
                                pad_type: STR_PAD_LEFT
                            )
                        ),
                        $mask
                    )
                );

                $memory[(int) $address] = bindec($value);
            }

            return array_sum($memory);
        });

        // Part 2
        yield value(function () {
            $memory = [];

            $mask = null;
            $floatingBitPositions = [];
            $floatingBitsPermutations = null;

            foreach ($this->puzzleInputLines() as $instruction) {
                if (str_starts_with($instruction, 'mask')) {
                    $mask = array_map(
                        callback: fn(string $bit) => is_numeric($bit) ? (int) $bit : null,
                        array: str_split(
                            substr($instruction, offset: -36)
                        )
                    );

                    $floatingBitPositions = array_keys(
                        array: array_filter(
                            array: $mask,
                            callback: 'is_null'
                        )
                    );

                    continue;
                }

                // Need to recreate generator doe to lack of rewinding.
                $floatingBitsPermutations = fn(): Generator => array_permutations(
                    haystack: [0, 1],
                    length: count($floatingBitPositions)
                );

                preg_match('/^\D*\[(\d+)\]\D*(\d+)$/', $instruction, $matches);

                [, $address, $value] = $matches;

                $address = array_map(
                    callback: 'intval',
                    array: str_split(
                        str_pad(
                            decbin((int) $address),
                            length: 36,
                            pad_string: '0',
                            pad_type: STR_PAD_LEFT
                        )
                    )
                );

                $address = array_map(
                    function (int $bit, ?int $maskBit) {
                        if (is_null($maskBit)) {
                            return null;
                        }

                        return $bit | $maskBit;
                    },
                    $address,
                    $mask
                );

                foreach ($floatingBitsPermutations() as $fluctuation) {
                    $fluctuation = array_combine($floatingBitPositions, $fluctuation);
                    $fluctuatingAddress = bindec(
                        join(
                            separator: '',
                            array: array_replace($address, $fluctuation)
                        )
                    );

                    $memory[$fluctuatingAddress] = $value;
                }
            }

            return array_sum($memory);
        });
    }
}
