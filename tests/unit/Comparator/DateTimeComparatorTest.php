<?php

namespace Ninja\Sorter\Tests\unit\Comparator;

use DateTime;
use Ninja\Sorter\Comparator\DateTimeComparator;
use PHPUnit\Framework\TestCase;

class DateTimeComparatorTest extends TestCase
{
    public static function formats(): array
    {
        return array(
            array(new DateTime(), true),           // date time
            array(123456, false),                   // integers
            array(123456.123, false),               // floats
            array(new \stdClass(), false),          // objects
            array(true, false),                     // booleans
        );
    }

    public static function values(): array
    {
        return [
            [
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                0
            ],
            [
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 13:56:11'),
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                1
            ],
            [
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 13:56:11'),
                -1
            ],
        ];
    }

    /**
     * @dataProvider formats
     */
    public function testSupportedFormats(mixed $value, bool $is_supported): void
    {
        $comparator = new DateTimeComparator();
        $this->assertSame($is_supported, $comparator->supports($value));
    }

    /**
     * @dataProvider values
     */
    public function testCompareValues($a, $b, $expectedResult): void
    {
        $comparator = new DateTimeComparator();
        $this->assertEquals($expectedResult, $comparator->compare($a, $b));
    }
}
