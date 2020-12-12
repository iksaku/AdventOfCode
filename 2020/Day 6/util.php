<?php

declare(strict_types=1);

namespace AdventOfCode2020\Day6;

require_once __DIR__ . '/../vendor/autoload.php';

class Group {
    public function __construct(
        public int $people,
        public array $answers = []
    ) {}

    public function addAnswers(string $answers): void
    {
        $this->answers = array_merge($this->answers, str_split($answers));
    }

    public static function make(string $puzzle): array
    {
        $answers = explode("\n\n", $puzzle);

        $groups = [];

        foreach ($answers as $group_answers) {
            $group_answers = explode("\n", $group_answers);

            $groups[] = $group = new self(count($group_answers));

            foreach ($group_answers as $individual_answers) {
                $group->addAnswers($individual_answers);
            }
        }

        return $groups;
    }
}

function answeredQuestions(string $puzzle): int
{
    $groups = Group::make($puzzle);

    return array_reduce(
        $groups,
        callback: fn(int $sum, Group $group) => $sum + count(array_unique($group->answers)),
        initial: 0
    );
}

function answeredQuestionsByEveryone(string $puzzle): int
{
    $groups = Group::make($puzzle);

    return array_reduce(
        $groups,
        callback: fn(int $sum, Group $group) => $sum + count(
            array_filter(
                array_count_values($group->answers),
                callback: fn(int $question_answered_times) => $question_answered_times === $group->people
            )
        ),
        initial: 0
    );
}
