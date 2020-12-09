<?php

include_once __DIR__ . '/../Day 2/util.php';


$example_puzzle = [
    '1-3 a: abcde',
    '1-3 b: cdefg',
    '2-9 c: ccccccccc',
];

it('can generate restrictions from a string')
    ->group('Day 2')
    ->assertEquals(
        expected: [
            new Restriction(1, 3, 'a', 'abcde'),
            new Restriction(1, 3, 'b', 'cdefg'),
            new Restriction(2, 9, 'c', 'ccccccccc'),
        ],
        actual: asRestrictions($example_puzzle)
    );

it('can validate against Sled Rental Place policies')
    ->group('Day 2')
    ->assertEquals(
        expected: 2,
        actual: solveForSledRentalPlace($example_puzzle)
    );

it('can validate against Toboggan Corporate policies')
    ->group('Day 2')
    ->assertEquals(
        expected: 1,
        actual: solveForTobogganCorporate($example_puzzle)
    );
