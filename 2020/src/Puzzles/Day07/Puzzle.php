<?php

declare(strict_types=1);

namespace AdventOfCode2020\Puzzles\Day07;

use AdventOfCode2020\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:07')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        $this->compileBagRules();

        $type = BagBank::getType('shiny gold');

        // Part 1
        yield BagBank::searchForContainers($type);

        // Part 2
        yield $type->getNestedBagCount();
    }

    protected function compileBagRules(): void
    {
        foreach ($this->puzzleInputLines() as $rule) {
            [$type, $rules] = explode('bags contain', $rule);

            $type = ltrim(rtrim($type));

            $bagType = BagBank::getType($type);

            if (
                preg_match_all(
                    pattern: '/(?<quantities>\d+) (?<types>[\w ]+) bag/s',
                    subject: $rules,
                    matches: $matches
                ) < 1
            ) continue;

            foreach ($matches['types'] as $i => $containedType) {
                $containedBagType = BagBank::getType($containedType);

                $bagType->addContainedBagType($containedBagType, (int) $matches['quantities'][$i]);
            }
        }
    }
}
