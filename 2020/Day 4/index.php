<?php

declare(strict_types=1);

include_once __DIR__ . '/util.php';

$puzzle = array_filter(
    explode(
        separator: "\n",
        string: preg_replace(
            pattern: '/(?<!^)\n(?!(\n|$))/m', // See: https://regexr.com/5hl4g
            replacement: ' ',
            subject: file_get_contents(__DIR__.'/puzzle.txt')
        )
    )
);

$looselyValidPasswords = array_reduce(
    array: $puzzle,
    callback: fn(?int $count, string $passport) => ($count ?? 0) + (int) Validator::looseValidate($passport)
);
echo "Found {$looselyValidPasswords} loosely valid passwords." . PHP_EOL;

$strictlyValidPasswords = array_reduce(
    array: $puzzle,
    callback: fn(?int $count, string $passport) => ($count ?? 0) + (int) Validator::strictValidate($passport)
);
echo "Found {$strictlyValidPasswords} strictly valid passwords." . PHP_EOL;
