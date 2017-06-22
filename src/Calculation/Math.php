<?php
/**
 * contains some helpful mathematics models
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */
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
    public static function getPercentDifference($from, $into)
    {
        if ($into === 0) {
            return false;
        }

        return 100 - (($into / $from) *100);
    }

    /**
     * calculate with percent is one number of other
     *
     * @param float $part value that is percent of other value
     * @param float $all value to check percent
     * @return integer|boolean return false if $all was 0 value
     */
    public static function numberToPercent($part, $all)
    {
        if ($all === 0) {
            return false;
        }

        return ($part / $all) *100;
    }

    /**
     * calculate percent form value
     *
     * @param float $part value that will be percent of other value
     * @param float $all value from calculate percent
     * @return integer
     */
    public static function percent($part, $all)
    {
        if ($all === 0) {
            return false;
        }

        return ($part / 100) *$all;
    }

    /**
     * estimate time to end, by given current usage value and max value
     *
     * @param float $edition maximum number of value
     * @param float $used how many was used
     * @param integer $start start time in unix timestamp
     * @param integer $timeNow current unix timestamp
     * @return integer estimated end time in unix timestamp
     */
    public static function end($edition, $used, $start, $timeNow)
    {
        if (!$used) {
            return 0;
        }

        $end = $edition / ($used / ($timeNow - $start));
        $end += $timeNow;

        return $end;
    }
}
