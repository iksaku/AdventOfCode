<?php

declare(strict_types=1);

if (!function_exists('array_combinations')) {
    /**
     * Return all possible combinations from values of an array.
     *
     * The reason behind this generator is due to Day 1's puzzle.
     * It contains 200 values, and dimension size will exponentially
     * increase the memory needed to compute by a factor of "(n^s)*s",
     * where:
     *      n: Count of items in the original array.
     *      s: Dimension size of the combination.
     *
     * Day 1 Part 2 expects a 3 dimension combination from a puzzle
     * of 200 elements, which would result in a fully computed array
     * with 200^3 sub-arrays, holding 3 integers each. So a total
     * of (200^3)*3 elements. This is not good for memory consumption.
     *
     * The only solution I could came up with to decrease memory usage
     * was to use function generators, which work wonderfully, almost
     * seem like black magic to me! (PS: They're not).
     *
     * @param array $haystack
     * @param int $dimensions
     * @return Generator
     */
    function array_combinations(array $haystack, int $dimensions): Generator
    {
        if ($dimensions <= 0) {
            throw new ValueError('Size must be higher than zero.');
        }

        if (empty($haystack)) {
            throw new ValueError('Haystack must contain at least 1 element to combine.');
        }

        if ($dimensions === 1) {
            return yield from $haystack;
        }

        foreach ($haystack as $value) {
            foreach (array_combinations($haystack, $dimensions - 1) as $combined) {
                yield [$value, ...array_wrap($combined)];
            }
        }
    }
}


if (!function_exists('array_first')) {
    /**
     * Obtain the first element in a Traversable that passes a given truth test.
     *
     * @see https://github.com/illuminate/collections/blob/99889ebfe8eb73afa6859b316657f8cac6d20b1c/Arr.php#L166-L185
     *
     * @param array|Traversable $haystack
     * @param Closure $callback
     * @param mixed|null $default
     * @return mixed
     */
    function array_first(array|Traversable $haystack, Closure $callback, mixed $default = null): mixed
    {
        foreach ($haystack as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default instanceof Closure ? $default() : $default;
    }
}

if (!function_exists('array_map_with_keys')) {
    /**
     * Pass each key-value pair of an array into a function.
     *
     * @param callable $callback
     * @param array $array
     * @return array
     */
    function array_map_with_keys(callable $callback, array $array): array
    {
        $keys = array_keys($array);

        $items = array_map($callback, $array, $keys);

        return array_combine($keys, $items);
    }
}

if (!function_exists('array_value_first')) {
    /**
     * Return the first element of an array.
     *
     * @param array $haystack
     * @return mixed
     */
    function array_value_first(array $haystack): mixed
    {
        return $haystack[array_key_first($haystack)];
    }
}

if (!function_exists('array_value_last')) {
    /**
     * Return the last element of an array.
     *
     * @param array $haystack
     * @return mixed
     */
    function array_value_last(array $haystack): mixed
    {
        return $haystack[array_key_last($haystack)];
    }
}

if (!function_exists('array_wrap')) {
    /**
     * Wraps a non-array value into an array.
     *
     * @param mixed $value
     * @return array
     */
    function array_wrap(mixed $value): array
    {
        return is_array($value) ? $value : [$value];
    }
}
