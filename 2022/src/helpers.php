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
