<?php
/**
 * test Math
 *
 * @package     BlueData
 * @subpackage  Test
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */
namespace Test;

use BlueData\Calculation\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    public function testGetPercentDifference()
    {
        $this->assertEquals(-200, Math::getPercentDifference(10, 30));
        $this->assertEquals(50, Math::getPercentDifference(20, 10));
        $this->assertEquals(0, Math::getPercentDifference(10, 0));
    }

    public function testNumberToPercent()
    {
        $this->assertEquals(50, Math::numberToPercent(10, 20));
        $this->assertEquals(200, Math::numberToPercent(20, 10));
        $this->assertEquals(0, Math::numberToPercent(10, 0));
    }

    public function testPercent()
    {
        $this->assertEquals(10, Math::percent(10, 100));
        $this->assertEquals(10, Math::percent(100, 10));
        $this->assertEquals(0, Math::percent(10, 0));
    }

    public function testEnd()
    {
        $currentTime = 1498136062;
        $startTime = 1498136000;

        $this->assertEquals(1498136682, Math::end(1000, 100, $startTime, $currentTime));
        $this->assertEquals(0, Math::end(1000, 0, $startTime, $currentTime));
    }

    /**
     * @param array $data
     * @param array $result
     * @dataProvider data
     */
    public function testMedian(array $data, array $result)
    {
        $this->assertEquals($result['median'], Math::median($data));
    }

    /**
     * @param array $data
     * @param array $result
     * @dataProvider data
     */
    public function testAverage(array $data, array $result)
    {
        $this->assertEquals($result['avg'], Math::average($data));
    }

    public static function data(): array
    {
        return [
            [
                [1,1,1,1,2,2,3,1,100,5,3,7,2,3,62,8,9,45,3,2,45,6,7,8,99,6,64,3,2,22,1,1],
                [
                    'avg' => 16.40625,
                    'median' => 3,
                ]
            ],
            [
                [1,2,2,3,1,100,5,3,7,2,3,62,8,9,45,3,2,45,6,7,8,99,6,64,3,2,22,1,1],
                [
                    'avg' => 18,
                    'median' => 5,
                ]
            ]
        ];
    }
}
