<?php

declare(strict_types=1);

use JetBrains\PhpStorm\Pure;

include_once __DIR__.'/../vendor/autoload.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$valid_passwords_from_character_count = 0;
$valid_passwords_from_character_position = 0;

#[Pure]
function character_count_restriction(
    string $password,
    string $character_restriction,
    int $min_count_restriction,
    int $max_count_restriction
): bool
{
    $password_character_count = array_count_values(str_split($password));
    $restricted_character_count = $password_character_count[$character_restriction] ?? 0;

    return $restricted_character_count >= $min_count_restriction
        && $restricted_character_count <= $max_count_restriction;
}

function character_position_restriction(
    string $password,
    string $character_restriction,
    int $first_position,
    int $second_position
): bool
{
    // Note: Remember they don't have a Zero-index policy, but PHP does :sweat_smile:
    --$first_position;
    --$second_position;

    return $character_restriction === $password[$first_position]
        xor $character_restriction === $password[$second_position];
}

foreach ($puzzle as $line) {
    [$restriction_count, $restriction_letter, $password] = explode(' ', $line);

    [$restriction_min, $restriction_max] = explode('-', $restriction_count);
    $restriction_letter = str_replace(':', '', $restriction_letter);

    // Part 1
    if (character_count_restriction(
        password: $password,
        character_restriction: $restriction_letter,
        min_count_restriction: (int) $restriction_min,
        max_count_restriction: (int) $restriction_max
    )) ++$valid_passwords_from_character_count;

    // Part 2
    if (character_position_restriction(
        password: $password,
        character_restriction: $restriction_letter,
        first_position: (int) $restriction_min,
        second_position: (int) $restriction_max
    )) ++$valid_passwords_from_character_position;
}

echo "[Part 1] There are {$valid_passwords_from_character_count} valid passwords in the database." . PHP_EOL;
echo "[Part 2] There are {$valid_passwords_from_character_position} valid passwords in the database." . PHP_EOL;
