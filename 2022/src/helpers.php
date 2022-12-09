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

function array_value_last(array $array): mixed
{
    return $array[array_key_last($array)];
}

function array_transpose(array $array): array
{
    return array_map(null, ...$array);
}

function array_rotate_right(array $array): array
{
    return array_map(
        callback: array_reverse(...),
        array: array_transpose($array)
    );
}

function iterable_reduce(iterable $iterable, Closure $callback, mixed $initial = null): mixed
{
    $result = $initial;

    foreach ($iterable as $key => $value) {
        $result = $callback($result, $value, $key);
    }

    return $result;
}

function iterable_sum_using(iterable $iterable, Closure $callback): int
{
    return iterable_reduce(
        iterable: $iterable,
        callback: fn (int $result, mixed $value, mixed $key) => $result + $callback($value, $key),
        initial: 0
    );
}

function iterable_count_using(iterable $iterable, Closure $callback): int
{
    return iterable_sum_using(
        iterable: $iterable,
        callback: fn (mixed $value, mixed $key) => (int) (bool) $callback($value, $key)
    );
}

function iterable_filter_using(iterable $iterable, Closure $callback): Generator
{
    foreach ($iterable as $key => $value) {
        if ($callback($value, $key)) {
            yield $key => $value;
        }
    }
}

function iterable_map_using(iterable $iterable, Closure $callback): Generator
{
    foreach ($iterable as $key => $value) {
        yield $key => $callback($value, $key);
    }
}
