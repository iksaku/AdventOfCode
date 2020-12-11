<?php

declare(strict_types=1);

require_once __DIR__ . '/util.php';

$puzzle = array_map(
    callback: 'extractStringData',
    array: array_filter(
        explode(
            separator: "\n",
            string: preg_replace(
                pattern: '/(?<!^)\n(?!(\n|$))/m', // See: https://regexr.com/5hl4g
                replacement: ' ',
                subject: file_get_contents(__DIR__.'/puzzle.txt')
            )
        )
    )
);

$looselyValidPasswords = array_reduce(
    array: $puzzle,
    callback: fn(?int $count, array $passport) => ($count ?? 0) + (int) validateHasAllFields($passport)
);
echo "Found {$looselyValidPasswords} loosely valid passwords." . PHP_EOL;

$strictlyValidPasswords = array_reduce(
    array: $puzzle,
    callback: fn(?int $count, array $passport) => ($count ?? 0) + (int) isValid($passport)
);
echo "Found {$strictlyValidPasswords} strictly valid passwords." . PHP_EOL;
