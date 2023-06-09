<?php

namespace Ninja\Sorter\Tests\unit\Comparator;

use Ninja\Sorter\Comparator\NumericComparator;
use PHPUnit\Framework\TestCase;

class NumericComparatorTest extends TestCase
{
    public static function formats(): array
    {
        return array(
            array(123456, true),                   // integers
            array(123456.123, true),               // floats
            array(new \DateTime(), false),         // date time
            array(new \stdClass(), false),         // objects
            array(true, false),                    // booleans
        );
    }

    public static function values(): array
    {
        return array(
            array(-1000, -100, -1),
            array(1000, -100, 1),
            array(-100, -100, 0),

            array(-100, -1000, 1),
            array(-100, 1000, -1),

            array(100, 1000, -1),
            array(1000, 100, 1),
            array(100, 100, 0),

            array('100.00', '100.00', 0),
            array('101.00', '100.00', 1),
            array('101.00', '-100.00', 1),
            array('100.00', '101.00', -1),
            array('-100.00', '101.00', -1),

            array('100', '100', 0),
        );
    }

    /**
     * @dataProvider formats
     */
    public function testSupportedFormats(mixed $value, $is_supported): void
    {
        $comparator = new NumericComparator();
        $this->assertSame($is_supported, $comparator->supports($value));
    }

    /**
     * @dataProvider values
     */
    public function testCompareValues($a, $b, $expectedResult): void
    {
        $comparator = new NumericComparator();
        $this->assertEquals($expectedResult, $comparator->compare($a, $b));
    }
}
