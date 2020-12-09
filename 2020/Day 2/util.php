<?php

include_once __DIR__.'/../vendor/autoload.php';

class Restriction {
    public function __construct(
        public int $min_range,
        public int $max_range,
        public string $letter,
        public string $password,
    ) {}

    public static function make(string $line): self
    {
        [$restriction_count, $restriction_letter, $password] = explode(' ', $line);

        [$restriction_min, $restriction_max] = explode('-', $restriction_count);
        $restriction_letter = str_replace(':', '', $restriction_letter);

        return new self($restriction_min, $restriction_max, $restriction_letter, $password);
    }

    public static function makeMany(array $lines): array
    {
        return array_map([Restriction::class, 'make'], $lines);
    }

    public function isValidForSledRentalPlace(): bool
    {
        $password_character_count = array_count_values(str_split($this->password));

        $restriction_occurrences = $password_character_count[$this->letter] ?? 0;

        return $restriction_occurrences >= $this->min_range
            && $restriction_occurrences <= $this->max_range;
    }

    public function isValidForTobogganCorporate(): bool
    {
        // Note: They have no zero-index concept, but PHP does :sweat_smile:
        $first_position = $this->min_range - 1;
        $last_position = $this->max_range - 1;

        return $this->letter === $this->password[$first_position]
            xor $this->letter === $this->password[$last_position];
    }
}

function solveForSledRentalPlace(array $puzzle): int
{
    return count(
        array_filter(
            Restriction::makeMany($puzzle),
            fn(Restriction $restriction) => $restriction->isValidForSledRentalPlace()
        )
    );
}

function solveForTobogganCorporate(array $puzzle): int
{
    return count(
        array_filter(
            Restriction::makeMany($puzzle),
            fn(Restriction $restriction) => $restriction->isValidForTobogganCorporate()
        )
    );
}
