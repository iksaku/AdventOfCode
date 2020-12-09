<?php

declare(strict_types=1);

if (!function_exists('array_value_first')) {
    function array_value_first(array $haystack): mixed
    {
        return $haystack[array_key_first($haystack)];
    }
}

if (!function_exists('array_value_last')) {
    function array_value_last(array $haystack): mixed
    {
        return $haystack[array_key_last($haystack)];
    }
}
