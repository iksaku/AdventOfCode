<?php

declare(strict_types=1);

function blank(mixed $value): bool
{
    if (is_null($value)) {
        return true;
    }

    if (is_string($value)) {
        return trim($value) === '';
    }

    if (is_numeric($value) || is_bool($value)) {
        return false;
    }

    if ($value instanceof Countable) {
        return count($value) === 0;
    }

    return empty($value);
}

function filled(mixed $value): bool
{
    return ! blank($value);
}

function value(mixed $value, mixed ...$params): mixed
{
    return is_callable($value) ? $value(...$params) : $value;
}

function array_wrap(mixed $value): array
{
    return is_array($value) ? $value : [$value];
}

function array_combinations(array $haystack, int $length): Generator
{
    if ($length <= 0) {
        throw new ValueError('Length must be higher than zero.');
    }

    if (empty($haystack)) {
        throw new ValueError('Haystack must contain at least 1 element to iterate.');
    }

    if ($length === 1) {
        return yield from $haystack;
    }

    $lastIndex = array_key_last($haystack);
    foreach ($haystack as $i => $value) {
        if ($i === $lastIndex) {
            return yield $value;
        }

        foreach (array_combinations(array_slice($haystack, offset: $i + 1), length: $length - 1) as $combined) {
            yield [$value, ...array_wrap($combined)];
        }
    }
}

function array_permutations(array $haystack, int $length): Generator
{
    if ($length <= 0) {
        throw new ValueError('Length must be higher than zero.');
    }

    if (empty($haystack)) {
        throw new ValueError('Haystack must contain at least 1 element to iterate.');
    }

    if ($length === 1) {
        return yield from $haystack;
    }

    foreach ($haystack as $value) {
        foreach (array_permutations($haystack, length: $length - 1) as $permuted) {
            yield [$value, ...array_wrap($permuted)];
        }
    }
}

function between(int $value, int $min, int $max): bool
{
    return $value >= $min
        && $value <= $max;
}

function iterable_reduce(iterable $iterable, Closure $callback, mixed $initial = null): mixed
{
    $result = $initial;

    foreach ($iterable as $value) {
        $result = $callback($result, $value);
    }

    return $result;
}

function iterable_sum_using(iterable $iterable, Closure $callback): int
{
    return iterable_reduce(
        iterable: $iterable,
        callback: fn (int $result, mixed $value) => $result + $callback($value),
        initial: 0
    );
}

function iterable_count_using(iterable $iterable, Closure $callback): int
{
    return iterable_sum_using(
        iterable: $iterable,
        callback: fn (mixed $value) => (int) (bool) $callback($value)
    );
}

function iterable_map(iterable $iterable, Closure $callback): Generator
{
    foreach ($iterable as $item) {
        yield $callback($item);
    }
}

function array_deep_clone(array $array): array
{
    return array_map(
        callback: fn (mixed $value) => is_object($value) ? clone $value : $value,
        array: $array
    );
}

function array_value_last(array $haystack): mixed
{
    return $haystack[array_key_last($haystack)];
}
