<?php

declare(strict_types=1);

include_once __DIR__.'/../../vendor/autoload.php';
include_once __DIR__.'/../../Day 10/util.php';

uses()->group('Day 10');

it('can find joltage difference', function (array $puzzle, array $result) {
    $this->assertEquals(
        $result,
        findJoltageDifferences($puzzle)
    );
})->with([
    [
        $first_example = ['16', '10', '15', '5', '1', '11', '7', '19', '6', '12', '4'],
        [1 => 7, 3 => 5]
    ],
    [
        $second_example = ['28', '33', '18', '42', '31', '14', '46', '20', '48', '47', '24', '23', '49', '45', '19', '38', '39', '11', '1', '32', '25', '35', '8', '17', '7', '9', '4', '2', '34', '10', '3'],
        [1 => 22, 3 => 10]
    ],
]);

it('can find all arrangement possibilities', function (array $puzzle, int $result) {
    $this->assertEquals(
        $result,
        findPossibleCombinations($puzzle)
    );
})->with([
    [$first_example, 8],
    [$second_example, 19208],
]);
