<?php

declare(strict_types=1);
namespace AdventOfCode2020\Puzzles\Day07;

class BagType
{
    /** @var array<string, BagContainer>  */
    protected array $containedBags = [];

    public function __construct(
        public string $name
    ) {}

    public function addContainedBagType(BagType $bagType, int $quantity): void
    {
        $this->containedBags[$bagType->name] = new BagContainer($bagType, $quantity);
    }

    public function canContainType(BagType $bagType): bool
    {
        if (empty($this->containedBags)) {
            return false;
        }

        if (isset($this->containedBags[$bagType->name])) {
            return $this->containedBags[$bagType->name]->quantity > 0;
        }

        foreach ($this->containedBags as $bagContainer) {
            if ($bagContainer->bag->canContainType($bagType)) {
                return true;
            }
        }

        return false;
    }

    public function getNestedBagCount(): int
    {
        return iterable_sum_using(
            iterable: $this->containedBags,
            callback: fn (BagContainer $container) => $container->quantity + ($container->quantity * $container->bag->getNestedBagCount())
        );
    }
}
