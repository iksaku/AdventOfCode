<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day2;

require_once __DIR__ . '/../vendor/autoload.php';

class Restriction {
    public function __construct(
        public int $min_range,
        public int $max_range,
        public string $letter,
        public string $password,
    ) {}

    public static function make(string ...$lines): array
    {
        return array_map(
            callback: function (string $line) {
                [$restriction_count, $restriction_letter, $password] = explode(' ', $line);

                [$restriction_min, $restriction_max] = explode('-', $restriction_count);
                $restriction_letter = str_replace(':', '', $restriction_letter);

                return new self((int) $restriction_min, (int) $restriction_max, $restriction_letter, $password);
            },
            array: $lines
        );
    }
}

function solveForSledRentalPlace(array $puzzle): int
{
    return count(
        array_filter(
            Restriction::make(...$puzzle),
            function (Restriction $restriction) {
                $restriction_occurrences = substr_count($restriction->password, $restriction->letter) ?? 0;

                return $restriction_occurrences >= $restriction->min_range
                    && $restriction_occurrences <= $restriction->max_range;
            }
        )
    );
}

function solveForTobogganCorporate(array $puzzle): int
{
    return count(
        array_filter(
            Restriction::make(...$puzzle),
            fn(Restriction $restriction) =>
                // Note: They have no zero-index concept, but PHP does :sweat_smile:
                $restriction->letter === $restriction->password[$restriction->min_range - 1] xor
                $restriction->letter === $restriction->password[$restriction->max_range - 1]
        )
    );
}
