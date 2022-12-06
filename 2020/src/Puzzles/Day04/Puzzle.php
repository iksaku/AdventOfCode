<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day04;

use AdventOfCode2020\BasePuzzle;
use Closure;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:04')]
class Puzzle extends BasePuzzle
{
    protected const BIRTH_YEAR = 'byr';
    protected const ISSUE_YEAR = 'iyr';
    protected const EXPIRATION_YEAR = 'eyr';
    protected const HEIGHT = 'hgt';
    protected const HAIR_COLOR = 'hcl';
    protected const EYE_COLOR = 'ecl';
    protected const PASSPORT_ID = 'pid';

    protected function handle(): Generator
    {
        // Part 1
        yield iterable_count_using(
            iterable: $this->processPassports(),
            callback: fn (array $passport) => $this->validatePassportHasRequiredFields($passport)
        );

        // Part 2
        yield iterable_count_using(
            iterable: $this->processPassports(),
            callback: fn (array $passport) => $this->validatePassportHasRequiredFields($passport) && $this->validatePassportFields($passport)
        );
    }

    protected function processPassports(): Generator
    {
        $joinMultilinePassports = function () {
            $currentData = [];

            foreach ($this->puzzleInputLines() as $line) {
                if (filled($line)) {
                    $currentData[] = $line;
                    continue;
                }

                yield join(' ', $currentData);
                $currentData = [];
            }

            yield join(' ', $currentData);
        };

        foreach ($joinMultilinePassports() as $passport) {
            $fields = array_map(
                fn (string $field) => explode(':', $field),
                explode(' ', $passport)
            );

            yield array_combine(
                keys: array_column($fields, 0),
                values: array_column($fields, 1),
            );
        }
    }

    protected function validatePassportHasRequiredFields(array $passport): bool
    {
        $requiredFields = [
            self::BIRTH_YEAR,
            self::ISSUE_YEAR,
            self::EXPIRATION_YEAR,
            self::HEIGHT,
            self::HAIR_COLOR,
            self::EYE_COLOR,
            self::PASSPORT_ID,
        ];

        $included = array_intersect($requiredFields, array_keys($passport));

        return count($included) === count($requiredFields);
    }

    protected function validatePassportFields(array $passport): bool
    {
        $digits = fn (int $digits) => fn (string $value) => strlen($value) === $digits;
        $between = fn (int $min, int $max) => fn (string $value) => between((int) $value, $min, $max);

        $rules = [
            self::BIRTH_YEAR => [
                $digits(4),
                $between(1920, 2002),
            ],
            self::ISSUE_YEAR => [
                $digits(4),
                $between(2010, 2020),
            ],
            self::EXPIRATION_YEAR => [
                $digits(4),
                $between(2020, 2030),
            ],
            self::HEIGHT => [
                function (string $value) {
                    preg_match('/^(?<height>\d+)(?<unit>\w+)$/', $value, $matches);

                    ['height' => $height, 'unit' => $unit] = $matches;

                    return match($unit) {
                        'cm' => between((int) $height, 150, 193),
                        'in' => between((int) $height, 59, 76),
                        default => false
                    };
                },
            ],
            self::HAIR_COLOR => [
                fn (string $value) => (bool) preg_match('/^#[0-9a-f]{6}$/', $value),
            ],
            self::EYE_COLOR => [
                fn (string $value) => in_array($value, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']),
            ],
            self::PASSPORT_ID => [
                fn (string $value) => (bool) preg_match('/^\d{9}$/', $value),
            ]
        ];

        foreach ($passport as $field => $value) {
            foreach ($rules[$field] ?? [] as $fieldRule) {
                if (! $fieldRule($value)) {
                    return false;
                }
            }
        }

        return true;
    }
}
