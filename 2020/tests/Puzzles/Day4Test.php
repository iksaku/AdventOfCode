<?php

declare(strict_types=1);

include_once __DIR__ . '/../../Day 4/util.php';

uses()->group('Day 4');

it('can validate number digits', function (string $number, int $digits, bool $result) {
    $this->assertEquals(
        expected: $result,
        actual: Validator::digits($number, $digits)
    );
})->with([
    ['10', 4, false],
    ['1000', 4, true],
    ['0', 1, true],
    ['', 0, true],
    ['', 10, false]
]);

it('can validate number between other numbers', function (string $number, int $min, int $max, bool $result) {
    $this->assertEquals(
        expected: $result,
        actual: Validator::between($number, $min, $max)
    );
})->with([
    ['0', 1, 3, false],
    ['1', 1, 3, true],
    ['2', 1, 3, true],
    ['3', 1, 3, true],
    ['4', 1, 3, false]
]);

it('can validate height', function (string $height, bool $result) {
    $this->assertEquals(
        expected: $result,
        actual: Validator::height($height)
    );
})->with([
    ['149cm', false],
    ['150cm', true],
    ['170cm', true],
    ['193cm', true],
    ['194cm', false],
    ['58in', false],
    ['59in', true],
    ['65in', true],
    ['76in', true],
    ['77in', false],
    ['10', false],
    ['150', false],
    ['165', false],
    ['10km', false],
    ['150km', false],
    ['165km', false],
]);

it('can validate a regex pattern', function (string $needle, string $pattern, bool $result) {
    $this->assertEquals(
        expected: $result,
        actual: Validator::regex($needle, $pattern)
    );
})->with([
    ['a1b2c3', '/(\w\d)+/', true],
    ['a1b2c3', '/^[1-9]+$/', false],
    ['a1b2c3', '/^[a-z]+$/', false],
]);

it('can validate if needle is in an array', function (string $needle, array $haystack, bool $result) {
    $this->assertEquals(
        expected: $result,
        actual: Validator::in($needle, ...$haystack)
    );
})->with([
    ['foo', ['foo', 'bar'], true],
    ['baz', ['foo', 'bar'], false],
    ['blue', ['red', 'blue', 'green'], true],
    ['cyan', ['red', 'blue', 'green'], false],
]);

it('can validate using a loose method', function (string $rule, bool $result) {
    $this->assertEquals(
        expected: $result,
        actual: Validator::looseValidate($rule)
    );
})->with([
    ['ecl:gry pid:860033327 eyr:2020 hcl:#fffffd byr:1937 iyr:2017 cid:147 hgt:183cm', true],
    ['iyr:2013 ecl:amb cid:350 eyr:2023 pid:028048884 hcl:#cfa07d byr:1929', false],
    ['hcl:#ae17e1 iyr:2013 eyr:2024 ecl:brn pid:760753108 byr:1931 hgt:179cm', true],
    ['hcl:#cfa07d eyr:2025 pid:166559648 iyr:2011 ecl:brn hgt:59in', false],
]);

it('fails with invalid passports', function (string $rule) {
    $this->assertFalse(
        condition: Validator::strictValidate($rule)
    );
})->with([
    'eyr:1972 cid:100 hcl:#18171d ecl:amb hgt:170 pid:186cm iyr:2018 byr:1926',
    'iyr:2019 hcl:#602927 eyr:1967 hgt:170cm ecl:grn pid:012533040 byr:1946',
    'hcl:dab227 iyr:2012 ecl:brn hgt:182cm pid:021572410 eyr:2020 byr:1992 cid:277',
    'hgt:59cm ecl:zzz eyr:2038 hcl:74454a iyr:2023 pid:3556412378 byr:2007',
]);

it('succeeds with valid passports', function (string $rule) {
    $this->assertTrue(
        condition: Validator::strictValidate($rule)
    );
})->with([
    'pid:087499704 hgt:74in ecl:grn iyr:2012 eyr:2030 byr:1980 hcl:#623a2f',
    'eyr:2029 ecl:blu cid:129 byr:1989 iyr:2014 pid:896056539 hcl:#a97842 hgt:165cm',
    'hcl:#888785 hgt:164cm byr:2001 iyr:2015 cid:88 pid:545766238 ecl:hzl eyr:2022',
    'iyr:2010 hgt:158cm hcl:#b6652a ecl:blu byr:1944 eyr:2021 pid:093154719',
]);
