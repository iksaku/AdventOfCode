<?php

include_once __DIR__ . '/../Day 2/util.php';


$day_2_example = [
    '1-3 a: abcde',
    '1-3 b: cdefg',
    '2-9 c: ccccccccc',
];

it('can generate restrictions from a string', function (array $puzzle, array $restrictions) {
    $this->assertEquals(
        expected: $restrictions,
        actual: asRestrictions($puzzle)
    );
})
    ->with([
        [
            'puzzle' => $day_2_example,
            'restrictions' => [
                new Restriction(1, 3, 'a', 'abcde'),
                new Restriction(1, 3, 'b', 'cdefg'),
                new Restriction(2, 9, 'c', 'ccccccccc'),
            ],
        ]
    ])
    ->group('Day 2');

it('can validate against Sled Rental Place policies', function (array $puzzle) {
    $this->assertEquals(
        expected: 2,
        actual: solveForSledRentalPlace($puzzle)
    );
})
    ->with([[$day_2_example]])
    ->group('Day 2');

it ('can validate against Toboggan Corporate policies', function (array $puzzle) {
    $this->assertEquals(
        expected: 1,
        actual: solveForTobogganCorporate($puzzle)
    );
})
    ->with([[$day_2_example]])
    ->group('Day 2');
