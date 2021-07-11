<?php

declare(strict_types=1);

namespace PHPNumberFormat;

final class PHPNumberFormat
{
    private static string $decimalSeparator = ',';

    public static function setDecimalSeparator(string $decimalSeparator): void
    {
        self::$decimalSeparator = $decimalSeparator;
    }
    public static function format(string $mask, float $value): string
    {
        preg_match("/(?<integer>\d+)(\.(?<fraction>\d*))?/", (string) $value, $matchValue);
        preg_match("/(?<prefix>[^#]*)(?<integer>#[^" .self::$decimalSeparator . "]*#?)(" . self::$decimalSeparator . "(?<fraction>#+))?(?<suffix>[^#]*)/", $mask, $matchMask);

        $integer = self::processInteger($matchMask['integer'], $matchValue['integer']);

        $fraction = '';
        if ($matchMask['fraction'] !== '') {
            $fraction = self::$decimalSeparator . self::processFraction($matchMask['fraction'], $matchValue['fraction']);
        }

        return ($matchMask['prefix'] ?? '') . $integer . $fraction . ($matchMask['suffix'] ?? '');
    }

    private static function processFraction(
        string $fractionMask,
        string $fractionValue
    ): string {
        $maskaredValue = str_split($fractionMask);
        $value = str_split($fractionValue);
        $count = count($maskaredValue);
        for ($i = 0; $i < $count; $i++) {
            $maskaredValue[$i] = $maskaredValue[$i] === '#'
                                 ? array_shift($value) ?? '0'
                                 : $maskaredValue[$i];
        }

        return implode($maskaredValue);
    }

    private static function processInteger(
        string $integerMask,
        string $integerValue
    ): string {
        $maskaredValue = str_split($integerMask);
        $value = str_split($integerValue);

        for ($i = count($maskaredValue) - 1; $i >= 0; $i--) {
            $maskaredValue[$i] = $maskaredValue[$i] === '#'
                                 ? array_pop($value) ?? '0'
                                 : $maskaredValue[$i];
        }
        $maskaredValue = array_merge($value, $maskaredValue);

        return implode($maskaredValue);
    }
}
