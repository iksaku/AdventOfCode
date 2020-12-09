<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function executeInstruction(string $instruction, int &$position, int $param): void
{
    global $accumulator;

    $function = match($instruction) {
        'acc' => function (int &$i, int $param) use (&$accumulator): void {
            $accumulator += $param;
            ++$i;
        },
        'jmp' => function (int &$i, int $param): void {
            $i += $param;
        },
        default => function (int &$i, int $param): void {
            ++$i;
        }
    };

    $function($position, $param);
}

class InfiniteLoopException extends RuntimeException {
    public function __construct(
        public int $position
    ) {
        parent::__construct(
            "Found an execution loop at position {$this->position}.",
            1
        );
    }
}

function executeInstructionSet(
    ?array &$instruction_swap_attempts = null
): void
{
    global $puzzle, $executed_instructions;

    $has_swapped_instruction = false;

    for ($i = $last_position = 0; $i < count($puzzle);) {
        if (in_array($i, $executed_instructions)) throw new InfiniteLoopException($last_position);

        $last_position = $i;

        [$instruction, $param] = explode(' ', $puzzle[$i]);

        if (
            $instruction_swap_attempts !== null &&
            !$has_swapped_instruction &&
            in_array($instruction, ['nop', 'jmp']) &&
            !in_array($i, $instruction_swap_attempts)
        ) {
            $instruction = match ($instruction) {
                'nop' => 'jmp',
                'jmp' => 'nop',
                default => $instruction
            };

            $instruction_swap_attempts[] = $i;

            $has_swapped_instruction = true;
        }

        $executed_instructions[] = $i;
        executeInstruction(
            instruction: $instruction,
            position: $i,
            param: (int) $param
        );
    }
}

$executed_instructions = [];

$accumulator = 0;

try {
    executeInstructionSet();
} catch (InfiniteLoopException $loop) {
    echo "The accumulator value before a loop is {$accumulator}." . PHP_EOL;

    $instruction_swap_attempts = [];

    while (true) {
        $executed_instructions = [];

        $accumulator = 0;

        try {
            executeInstructionSet(
                instruction_swap_attempts: $instruction_swap_attempts
            );

            break;
        } catch (InfiniteLoopException $new_loop) {
            if (in_array($loop->position, $instruction_swap_attempts)) {
                echo "Unable to find a fixable instruction." . PHP_EOL;
                exit(1);
            }

            continue;
        }
    }

    echo "The accumulator value after fixed instruction set is {$accumulator}." . PHP_EOL;
}
