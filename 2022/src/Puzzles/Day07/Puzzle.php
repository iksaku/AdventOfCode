<?php

declare(strict_types=1);

namespace AdventOfCode2022\Puzzles\Day07;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:07')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        ray()->clearAll();
        $filesystem = $this->rootFilesystem();

        // Part 1
        yield iterable_sum_using(
            iterable: $filesystem->recursiveIterator(),
            callback: function (FilesystemItem $item) {
                if ($item instanceof File) {
                    return 0;
                }

                $size = $item->size();

                return $size < 100000
                    ? $size
                    : 0;
            }
        );

        // Part 2
        yield value(function () use ($filesystem) {
            $totalDiskSpace = 70000000;
            $unusedDiskSpace = $totalDiskSpace - $filesystem->size();

            $targetUnusedDiskSpace = 30000000;

            $deletionCandidates = iterator_to_array(
                iterable_filter_using(
                    iterable: iterable_map_using(
                        iterable: iterable_filter_using(
                            iterable: $filesystem->recursiveIterator(),
                            callback: fn (FilesystemItem $item) => $item instanceof Directory
                        ),
                        callback: fn (Directory $dir) => $dir->size()
                    ),
                    callback: fn (int $size) => ($unusedDiskSpace + $size) >= $targetUnusedDiskSpace
                )
            );

            return min($deletionCandidates);
        });
    }

    protected function rootFilesystem(): Directory
    {
        $root = new Directory(name: '/');

        /** @var ?Directory $context */
        $context = null;

        foreach ($this->puzzleInputLines() as $command) {
            $arguments = explode(' ', $command);

            if ($arguments[0] === '$') {
                array_shift($arguments); // Remove $
                $command = array_shift($arguments);

                if ($command === 'cd') {
                    $path = array_shift($arguments);

                    $context = match ($path) {
                        '/' => $root,
                        '..' => $context->parent,

                        default => value(function () use ($context, $path) {
                            if (! $context->exists($path)) {
                                $context->append(new Directory(name: $path, parent: $context));
                            }

                            return $context->get($path);
                        })
                    };

                    continue;
                }

                continue;
            }

            if (str_starts_with($command, 'dir')) {
                [, $path] = $arguments;
                $context->append(new Directory(name: $path, parent: $context));

                continue;
            }

            [$size, $file] = $arguments;

            $context->append(new File(name: $file, size: (int) $size, parent: $context));
        }

        return $root;
    }
}
