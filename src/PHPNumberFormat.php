<?php

declare(strict_types=1);

namespace PHPNumberFormat;

final class PHPNumberFormat
{
    public static function format(string $mask, float $value): string
    {
        preg_match("/(?<integer>\d+)(\.(?<fraction>\d*))/", (string) $value, $matchValue);
        preg_match('/(?<integer>#[^,]*#?)(,(?<fraction>#+))?/', $mask, $matchMask);

        $integer = PHPNumberFormat::fillInteger($matchMask['integer'], $matchValue['integer']);

        if (isset($matchMask['fraction'])) {
            $fraction = PHPNumberFormat::fillFraction($matchMask['fraction'], $matchValue['fraction']);
            return $integer . ',' . $fraction;
        }

        return $integer;
    }

    private static function fillFraction(string $fractionMask, string $fractionValue): string
    {
        $value = '';

        while (strlen($fractionMask) > 0) {
            $value .= strlen($fractionValue) <= 0 ? '0' : $fractionValue[0];

            $fractionValue = substr($fractionValue, 1, strlen($fractionValue));
            $fractionMask = substr($fractionMask, 1, strlen($fractionMask));
        }

        return $value;
    }

    private static function fillInteger(
        string $integerMask,
        string $integerValue
    ): string {
        $maskaredValue = str_split($integerMask);
        $value = str_split($integerValue);

        for ($i = count($maskaredValue) - 1; $i >= 0; $i--) {
            $maskaredValue[$i] = $maskaredValue[$i] === '#' ? array_pop($value) : $maskaredValue[$i];
        }
        $maskaredValue = array_merge($value, $maskaredValue);
        $maskaredValue = array_map(static fn ($v) => empty($v) ? '0' : $v, $maskaredValue);

        return implode($maskaredValue);
    }
}
