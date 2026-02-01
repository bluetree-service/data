<?php

/**
 * contains some helpful mathematics models
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */

declare(strict_types=1);

namespace BlueData\Calculation;

class Math
{
    /**
     * Calculates percent difference between two numbers
     *
     * @param int|float $from
     * @param int|float $into
     * @return int|float
     */
    public static function getPercentDifference(int|float $from, int|float $into): int|float
    {
        if ($into === 0) {
            return 0;
        }

        return 100 - (($into / $from) * 100);
    }

    /**
     * Calculate which percent is one number of other
     *
     * @param int|float $part value that is percent of other value
     * @param int|float $all value to check percent
     * @return int|float
     */
    public static function numberToPercent(int|float $part, int|float $all): int|float
    {
        if ($all === 0) {
            return 0;
        }

        return ($part / $all) * 100;
    }

    /**
     * Calculate percent form value
     *
     * @param int|float $part value that will be percent of other value
     * @param int|float $all value from calculate percent
     * @return int|float
     */
    public static function percent(int|float $part, int|float $all): int|float
    {
        if ($all === 0) {
            return 0;
        }

        return ($part / 100) * $all;
    }

    /**
     * Estimate time to end, by given current usage value and max value
     *
     * @param int|float $edition maximum number of value
     * @param int|float $used how many was used
     * @param int $start start time in unix timestamp
     * @param int $timeNow current unix timestamp
     * @return int|float estimated end time in unix timestamp
     */
    public static function end(int|float $edition, int|float $used, int $start, int $timeNow): int|float
    {
        if (!$used) {
            return 0;
        }

        $end = $edition / ($used / ($timeNow - $start));
        $end += $timeNow;

        return $end;
    }

    /**
     * @param array $data
     * @return float|int
     */
    public static function median(array $data): float|int
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Cannot calculate median of empty array.');
        }

        \sort($data);
        $valuesCount = \count($data);

        if ($valuesCount % 2 === 1) {
            $median = $data[(int)(($valuesCount - 1) / 2)];
        } else {
            $lowerIndex = (int)($valuesCount / 2) - 1;
            $upperIndex = (int)($valuesCount / 2);
            $median = ($data[$lowerIndex] + $data[$upperIndex]) / 2;
        }

        return $median;
    }

    /**
     * @param array $data
     * @return float|int
     */
    public static function average(array $data): float|int
    {
        return \array_sum($data) / \count($data);
    }
}
