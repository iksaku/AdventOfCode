<?php

declare(strict_types=1);
namespace AdventOfCode2020;

use Generator;
use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Termwind\render;
use function Termwind\renderUsing;

abstract class BasePuzzle extends Command
{
    public InputInterface $commandInput;
    public OutputInterface $commandOutput;

    protected function configure(): void
    {
        $this->addOption(name: 'example', shortcut: 'e', description: 'Run puzzle with provided example input');
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandInput = $input;
        $this->commandOutput = $output;

        renderUsing($output);

        foreach ($this->handle() as $part => $result) {
            ++$part;

            render(<<<HTML
                    <p class="ml-1">
                        <span class="bg-blue-500 text-gray-100 px-1">
                            Puzzle Part #{$part}
                        </span>
                        Result:
                        <span class="text-green-500">
                            {$result}
                        </span>
                    </p>
                HTML
            );
        }

        return Command::SUCCESS;
    }

    abstract protected function handle(): Generator;

    protected function inExampleMode(): bool
    {
        return $this->commandInput->getOption('example');
    }

    private function puzzleInputFilePath(): string
    {
        $path = dirname((new ReflectionClass(static::class))->getFileName());
        $path .= '/' . ($this->inExampleMode() ? 'example.txt' : 'input.txt');

        return $path;
    }

    private function puzzleInput(): string
    {
        static $cache = null;

        return $cache ??= rtrim(file_get_contents($this->puzzleInputFilePath()));
    }

    protected function puzzleInputLines(): array
    {
        static $cache = null;

        return $cache ??= value(function () {
            $lines = file($this->puzzleInputFilePath(), FILE_IGNORE_NEW_LINES);

            if (blank($lines[array_key_last($lines)])) {
                array_pop($lines);
            }

            return $lines;
        });
    }
}
