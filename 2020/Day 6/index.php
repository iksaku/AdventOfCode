<?php

include_once __DIR__.'/../vendor/autoload.php';

class Group {
    public function __construct(
        public int $people = 0,
        public array $answers = []
    ) {}

    public function addAnswers(string $answers): void
    {
        $this->answers = array_merge($this->answers, str_split($answers));
    }
}

function chunkBetweenEmptyLines(array $lines): array
{
    $result = [new Group()];

    foreach ($lines as $line) {
        if (empty($line)) {
            $result[] = new Group();
            continue;
        }

        $current_group = $result[array_key_last($result)];

        ++$current_group->people;
        $current_group->addAnswers($line);
    }

    return $result;
}

$puzzle = chunkBetweenEmptyLines(file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES));

$total_answers_to_any_question = 0;
$total_answers_to_all_questions = 0;

foreach ($puzzle as $group) {
    $total_answers_to_any_question += count(array_unique($group->answers));

    $total_answers_to_all_questions += count(
        array_filter(
            array: array_count_values($group->answers),
            callback: fn(int $count) => $count === $group->people
        )
    );
}

echo "Total number of 'yes' answered questions: {$total_answers_to_any_question}." . PHP_EOL;
echo "Number of same questions answered 'yes' by each group member: {$total_answers_to_all_questions}." . PHP_EOL;
