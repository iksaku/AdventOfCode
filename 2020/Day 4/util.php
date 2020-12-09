<?php

declare(strict_types=1);

include_once __DIR__.'/../vendor/autoload.php';

class Validator {
    private const RULES = [
        'byr' => ['digits:4', 'between:1920,2002'],
        'iyr' => ['digits:4', 'between:2010,2020'],
        'eyr' => ['digits:4', 'between:2020,2030'],
        'hgt' => ['height'],
        'hcl' => ['regex:/^#[0-9a-f]{6}$/s'], // See: https://regexr.com/5hlb2
        'ecl' => ['in:amb,blu,brn,gry,grn,hzl,oth'],
        'pid' => ['regex:/^\d{9}$/s'] // See https://regexr.com/5hlbe
    ];

    public static function extractStringData(string $data): array
    {
        $fields = [];
        $data = explode(' ', $data);

        foreach ($data as $kv) {
            [$key, $value] = explode(':', $kv);
            $fields[$key] = $value;
        }

        return $fields;
    }

    public static function looseValidate(array|string $data): bool
    {
        if (is_string($data)) {
            $data = self::extractStringData($data);
        }

        return count(
            array_intersect_key(self::RULES, $data)
        ) === 7;
    }

    public static function strictValidate(array|string $data): bool
    {
        if (is_string($data)) {
            $data = self::extractStringData($data);
        }

        foreach ($data as $key => $under_validation) {
            $rules = self::RULES[$key] ?? null;

            if (empty($rules)) {
                unset($data[$key]);
                continue;
            }

            foreach ($rules as $function) {
                $values = [$under_validation];

                if (str_contains($function, ':')) {
                    [$function, $definition_values] = explode(':', $function);
                    $values = [
                        $under_validation,
                        ...array_map(
                            callback: function (string $value) {
                                if (filter_var($value, FILTER_VALIDATE_INT)) {
                                    $value = (int) $value;
                                }

                                return $value;
                            },
                            array: explode(',', $definition_values)
                        )
                    ];
                }

                if (!self::{$function}(...$values)) {
                    // Invalid Data
                    unset($data[$key]);
                    return false;
                }
            }
        }

        return count($data) === 7;
    }

    public static function digits(string $needle, int $digits): bool
    {
        return strlen($needle) === $digits;
    }

    public static function between(string $needle, int $min, int $max): bool
    {
        $needle = (int) $needle;

        return ($needle >= $min)
            && ($needle <= $max);
    }

    public static function height(string $needle): bool
    {
        if (!preg_match_all('/^(?<height>\d+)(?<system>cm|in)$/s', $needle, $matches)) {
            return false;
        }

        $height = array_value_first($matches['height']);
        $system = array_value_first($matches['system']);

        return match ($system) {
            'cm' => self::between($height, 150, 193),
            'in' => self::between($height, 59, 76),
            default => false
        };
    }

    public static function regex(string $needle, string $pattern): bool
    {
        return ((int) preg_match($pattern, $needle)) > 0;
    }

    public static function in(string $needle, string ...$haystack): bool
    {
        return in_array($needle, $haystack);
    }
}
