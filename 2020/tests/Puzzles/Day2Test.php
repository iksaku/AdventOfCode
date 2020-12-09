<?php

declare(strict_types=1);

include_once __DIR__ . '/../../Day 2/util.php';

uses()->group('Day 2');

$example_puzzle = [
    '1-3 a: abcde',
    '1-3 b: cdefg',
    '2-9 c: ccccccccc',
];

it('can generate restrictions from a string', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: [
        new Restriction(1, 3, 'a', 'abcde'),
        new Restriction(1, 3, 'b', 'cdefg'),
        new Restriction(2, 9, 'c', 'ccccccccc'),
    ],
        actual: Restriction::makeMany($example_puzzle)
    );
});

it('can validate against Sled Rental Place policies', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 2,
        actual: solveForSledRentalPlace($example_puzzle)
    );
});

it('can validate against Toboggan Corporate policies', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 1,
        actual: solveForTobogganCorporate($example_puzzle)
    );
});
