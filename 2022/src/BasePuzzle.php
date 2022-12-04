<?php

declare(strict_types=1);
namespace AdventOfCode2022;

use Generator;
use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Termwind\render;
use function Termwind\renderUsing;

abstract class BasePuzzle extends Command
{
    public readonly InputInterface $input;
    public readonly OutputInterface $output;

    protected function configure(): void
    {
        $this->addOption(name: 'example', shortcut: 'e', description: 'Run puzzle with provided example input');
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

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
        return $this->input->getOption('example');
    }

    private function getPuzzleInput(): string
    {
        static $cache = null;

        return $cache ??= value(function () {
            $path = dirname((new ReflectionClass(static::class))->getFileName());
            $path .= '/' . ($this->inExampleMode() ? 'example.txt' : 'input.txt');

            return rtrim(file_get_contents($path));
        });
    }

    protected function puzzleLineByLine(?int $chunkLength = null): array
    {
        static $lines = null;

        $lines ??= explode(PHP_EOL, $this->getPuzzleInput());

        if (! is_null($chunkLength)) {
            return array_chunk($lines, $chunkLength);
        }

        return $lines;
    }
}
