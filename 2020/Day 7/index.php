<?php

declare(strict_types=1);

include_once __DIR__ . '/../vendor/autoload.php';

$puzzle = file(__DIR__.'/puzzle.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

class BagBank {
    /** @var BagType[] */
    protected static array $bagTypes = [];

    public static function getType(string $type): BagType
    {
        return self::$bagTypes[$type] ??= new BagType($type);
    }

    public static function searchForContainers(BagType $type): int
    {
        $containers = 0;

        foreach (self::$bagTypes as $bagType) {
            if ($bagType->canContainType($type)) ++$containers;
        }

        return $containers;
    }
}

class BagContainer {
    public function __construct(
        public BagType $bag,
        public int $quantity
    ) {}
}

class BagType {
    /** @var array<string, BagContainer>  */
    protected array $containedBags = [];

    public function __construct(
        public string $name
    ) {}

    public function addContainedBagType(BagType $bagType, int $quantity): void
    {
        $this->containedBags[$bagType->name] = new BagContainer($bagType, $quantity);
    }

    public function canContainType(BagType $bagType): int
    {
        if (empty($this->containedBags)) return 0;

        if (isset($this->containedBags[$bagType->name])) {
            // Return allowed quantity
            return $this->containedBags[$bagType->name]->quantity;
        }

        $result = 0;

        foreach ($this->containedBags as $bagContainer) {
            $result = $bagContainer->bag->canContainType($bagType);

            if ($result) break;
        }

        return $result;
    }

    public function getNestedBagCount(): int
    {
        $containedCount = 0;

        foreach ($this->containedBags as $container) {
            $containedCount += $container->quantity + ($container->quantity * $container->bag->getNestedBagCount());
        }

        return $containedCount;
    }
}

foreach ($puzzle as $rule) {
    [$type, $rules] = preg_split(pattern: '/bags contain/s', subject: $rule);

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

$search = BagBank::getType('shiny gold');

$containers = BagBank::searchForContainers($search);

echo "There are {$containers} bags that can contain a 'shiny gold' bag." . PHP_EOL;
echo "'{$search->name}' must contain {$search->getNestedBagCount()} nested bags." . PHP_EOL;
