<?php

declare(strict_types=1);

use AdventOfCode2020\Day6\Group;
use function AdventOfCode2020\Day6\answeredQuestions;
use function AdventOfCode2020\Day6\answeredQuestionsByEveryone;

require_once __DIR__.'/../../Day 6/util.php';

uses()->group('Day 6');

$example_puzzle = <<<'PUZZLE'
abc

a
b
c

ab
ac

a
a
a
a

b
PUZZLE;

it('can convert puzzle into groups', function (string $puzzle, array $result) {
    $this->assertEquals(
        expected: $result,
        actual: Group::make($puzzle)
    );
})->with([
    [
        <<<'PUZZLE'
ab
PUZZLE,
        [new Group(1, ['a', 'b'])]
    ],
    [
        <<<'PUZZLE'
ab
cd
PUZZLE,
        [new Group(2, ['a', 'b', 'c', 'd'])]
    ],
    [
        <<<'PUZZLE'
ab
cd

ef

gh
PUZZLE,
        [
            new Group(2, ['a', 'b', 'c', 'd']),
            new Group(1, ['e', 'f']),
            new Group(1, ['g', 'h']),
        ]
    ]
]);

it('can count total answered questions', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 11,
        actual: answeredQuestions($example_puzzle)
    );
});

it('can count total answered questions by everyone in a group', function () use ($example_puzzle) {
    $this->assertEquals(
        expected: 6,
        actual: answeredQuestionsByEveryone($example_puzzle)
    );
});
