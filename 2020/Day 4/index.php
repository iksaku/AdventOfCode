<?php

declare(strict_types=1);

include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/validators.php';

$puzzle = array_filter(
    explode(
        separator: "\n",
        string: preg_replace(
            pattern: '/(?<!^)\n(?!(\n|$))/m', // See:https://regexr.com/5hl4g
            replacement: ' ',
            subject: file_get_contents(__DIR__.'/puzzle.txt')
        )
    )
);

$required_passport_fields = [
    'byr',
    'iyr',
    'eyr',
    'hgt',
    'hcl',
    'ecl',
    'pid',
    // 'cid',
];

$valid_loose_passports = 0;
$valid_strict_passports = 0;

foreach ($puzzle as $line) {
    $data = explode(separator: ' ', string: $line);

    $present_fields = [];

    foreach ($data as $kv) {
        [$k, $v] = explode(separator: ':', string: $kv);

        $present_fields[$k] = $v;
    }

    // Part 1
    $valid_field_count = count(array_intersect($required_passport_fields, array_keys($present_fields))) + 1;

    if ($valid_field_count !== 8) continue;

    ++$valid_loose_passports;

    // Part 2
    /**
     * @var string $byr
     * @var string $iyr
     * @var string $eyr
     * @var string $hgt
     * @var string $hcl
     * @var string $ecl
     * @var string $pid
     */
    extract(array: $present_fields);

    if (
        !(hasExactDigits($byr, 4) && isBetweenNumbers((int) $byr, 1920, 2002)) ||
        !(hasExactDigits($iyr, 4) && isBetweenNumbers((int) $iyr, 2010, 2020)) ||
        !(hasExactDigits($eyr, 4) && isBetweenNumbers((int) $eyr, 2020, 2030)) ||
        !isValidHeight($hgt) ||
        !preg_match('/^#[0-9a-f]{6}$/', $hcl) || // See: https://regexr.com/5hlb2
        !in_array($ecl, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']) ||
        !preg_match('/^\d{9}$/', $pid) // See https://regexr.com/5hlbe
    ) continue;

    ++$valid_strict_passports;
}

echo "Found {$valid_loose_passports} valid loose passports." . PHP_EOL;
echo "Found {$valid_strict_passports} valid strict passports." . PHP_EOL;
