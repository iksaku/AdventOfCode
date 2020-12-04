<?php

use JetBrains\PhpStorm\Pure;

#[Pure]
function hasExactDigits (string $needle, int $digits): bool
{
    return strlen($needle) === $digits;
}

#[Pure]
function isBetweenNumbers (int $needle, int $min, int $max): bool
{
    return ($needle >= $min)
        && ($needle <= $max);
}

function isValidHeight (string $height): bool
{
    if(
        !($isCentimeters = str_contains($height, 'cm')) &&
        !str_contains($height, 'in')
    ) {
        return false;
    }

    $height = (int) preg_replace('/\D/', '', $height);

    return ($isCentimeters && isBetweenNumbers($height, 150, 193))
        || (!$isCentimeters && isBetweenNumbers($height, 59, 76));
}
