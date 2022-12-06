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

function value(callable $value): mixed
{
    return is_callable($value) ? $value() : $value;
}

function array_value_first(array $array): mixed
{
    return $array[array_key_first($array)];
}

function array_transpose(array $array): array
{
    return array_map(null, ...$array);
}

function array_rotate_right(array $array): array
{
    return array_map(
        array_reverse(...),
        array_transpose($array)
    );
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
