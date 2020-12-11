<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day4;

require_once __DIR__ . '/../vendor/autoload.php';

function validateHasAllFields(array $passport): bool
{
    return count(
            array_intersect(
                ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'],
                array_keys($passport)
            )
        ) === 7;
}

function validatePassport(array $passport): bool
{
    if (!validateHasAllFields($passport)) return false;

    return
        (digits($passport['byr'], 4) && between($passport['byr'], 1929, 2002)) &&
        (digits($passport['iyr'], 4) && between($passport['iyr'], 2010, 2020)) &&
        (digits($passport['eyr'], 4) && between($passport['eyr'], 2020, 2030)) &&
        in_array($passport['ecl'], ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']) &&
        // See: https://regexr.com/5hlb2
        preg_match('/^#[0-9a-f]{6}$/s', $passport['hcl']) &&
        // See https://regexr.com/5hlbe
        preg_match('/^\d{9}$/s', $passport['pid']) &&
        height($passport['hgt']);
}

function extractStringData(string $data): array
{
    $fields = [];
    $data = explode(' ', $data);

    foreach ($data as $kv) {
        [$key, $value] = explode(':', $kv);
        $fields[$key] = $value;
    }

    return $fields;
}

function digits(string $needle, int $digits): bool
{
    return strlen($needle) === $digits;
}

function between(string $needle, int $min, int $max): bool
{
    $needle = (int) $needle;

    return ($needle >= $min)
        && ($needle <= $max);
}

function height(string $needle): bool
{
    if (!preg_match_all('/^(?<height>\d+)(?<system>cm|in)$/s', $needle, $matches)) {
        return false;
    }

    $height = array_value_first($matches['height']);
    $system = array_value_first($matches['system']);

    return match ($system) {
        'cm' => between($height, 150, 193),
        'in' => between($height, 59, 76),
        default => false
    };
}
