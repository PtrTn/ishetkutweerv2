<?php

namespace Helpers;

class BeaufortCalculator
{
    public static function getBeaufort($windSpeed)
    {
        foreach(self::getRanges() as $beaufort => $range) {
            if ($windSpeed >= $range['min'] && $windSpeed <= $range['max']) {
                return $beaufort;
            }
            if ($windSpeed >= $range['min'] && $range['max'] === false) {
                return $beaufort;
            }
        }
        return false;
    }

    private static function getRanges()
    {
        return [
            0 => ['min' => 0,'max' => 1],
            1 => ['min' => 2,'max' => 5],
            2 => ['min' => 6,'max' => 11],
            3 => ['min' => 12,'max' => 19],
            4 => ['min' => 20,'max' => 28],
            5 => ['min' => 29,'max' => 38],
            6 => ['min' => 39,'max' => 49],
            7 => ['min' => 50,'max' => 61],
            8 => ['min' => 62,'max' => 74],
            9 => ['min' => 75,'max' => 88],
            10 => ['min' => 89,'max' => 102],
            11 => ['min' => 103,'max' => 117],
            12 => ['min' => 177,'max' => false]
        ];
    }
}
 