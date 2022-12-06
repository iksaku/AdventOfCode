<?php

declare(strict_types=1);
namespace AdventOfCode2020\Puzzles\Day07;

class BagBank {
    /** @var BagType[] */
    protected static array $bagTypes = [];

    public static function getType(string $type): BagType
    {
        return self::$bagTypes[$type] ??= new BagType($type);
    }

    public static function searchForContainers(BagType $type): int
    {
        return iterable_count_using(
            iterable: self::$bagTypes,
            callback: fn (BagType $bagType) => $bagType->canContainType($type)
        );
    }
}
