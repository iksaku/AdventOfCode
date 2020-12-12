<?php

declare(strict_types=1);

use function AdventOfCode2020\Day6\answeredQuestions;
use function AdventOfCode2020\Day6\answeredQuestionsByEveryone;

include_once __DIR__ . '/util.php';

$puzzle = rtrim(file_get_contents(__DIR__.'/puzzle.txt'));

echo 'Total count of positively answered questions: ' . answeredQuestions($puzzle) . '.' . PHP_EOL;
echo 'Count of questions answered positively by all group people: ' . answeredQuestionsByEveryone($puzzle) . '.' . PHP_EOL;
