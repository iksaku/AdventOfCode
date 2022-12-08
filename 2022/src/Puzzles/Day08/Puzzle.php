<?php

declare(strict_types=1);

namespace AdventOfCode2022\Puzzles\Day08;

use AdventOfCode2022\BasePuzzle;
use Generator;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'day:08')]
class Puzzle extends BasePuzzle
{
    protected function handle(): Generator
    {
        // Part 1
        yield value(function () {
            $visibleFromOutside =
                // Count both left and right edges
                (count($this->forestMap()) * 2)
                // Count both top and down edges, excluding corners
                + ((count(array_value_first($this->forestMap())) * 2) - 4);

            for ($x = 1; $x < count($this->forestMap()) - 1; ++$x) {
                $otherTreesInRow = $this->forestMap()[$x];

                for ($y = 1; $y < count($otherTreesInRow) - 1; ++$y) {
                    $treeHeight = $otherTreesInRow[$y];
                    $otherTreesInColumn = array_column($this->forestMap(), $y);

                    $neighborSections = [
                        'top'    => array_slice($otherTreesInColumn, offset: 0, length: $x),
                        'bottom' => array_slice($otherTreesInColumn, offset: $x + 1),
                        'left'   => array_slice($otherTreesInRow, offset: 0, length: $y),
                        'right'  => array_slice($otherTreesInRow, offset: $y + 1),
                    ];

                    foreach ($neighborSections as $neighborTreeHeights) {
                        if ($treeHeight > max($neighborTreeHeights)) {
                            ++$visibleFromOutside;
                            continue 2;
                        }
                    }
                }
            }

            return $visibleFromOutside;
        });

        // Part 2
        yield value(function () {
            $bestScenicScore = 0;

            foreach ($this->forestMap() as $x => $otherTreesInRow) {
                foreach ($otherTreesInRow as $y => $treeHeight) {
                    $otherTreesInColumn = array_column($this->forestMap(), $y);

                    $neighborSections = [
                        'top'    => array_reverse(array_slice($otherTreesInColumn, offset: 0, length: $x)),
                        'bottom' => array_slice($otherTreesInColumn, offset: $x + 1),
                        'left'   => array_reverse(array_slice($otherTreesInRow, offset: 0, length: $y)),
                        'right'  => array_slice($otherTreesInRow, offset: $y + 1),
                    ];


                    $scenicScore = 1;

                    foreach ($neighborSections as $neighborTreeHeights) {
                        $viewDistance = 0;

                        foreach ($neighborTreeHeights as $otherTreeHeight) {
                            ++$viewDistance;

                            if ($treeHeight <= $otherTreeHeight) {
                                break;
                            }
                        }

                        $scenicScore *= $viewDistance;
                    }

                    $bestScenicScore = max($scenicScore, $bestScenicScore);
                }
            }

            return $bestScenicScore;
        });
    }

    protected function forestMap(): array
    {
        static $cache = null;

        return $cache ??= array_map(
            callback: fn (string $row) => array_map(
                callback: 'intval',
                array: str_split($row)
            ),
            array: $this->puzzleInputLines()
        );
    }
}
