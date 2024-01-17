<?php

namespace Ninja\Sorter\Tests\unit\Comparator;

use DateTime;
use Ninja\Sorter\Comparator\DateTimeComparator;
use PHPUnit\Framework\TestCase;

class DateTimeComparatorTest extends TestCase
{
    /**
     * @return array<int, array<int,mixed>>
     */
    public static function formats(): array
    {
        return [
            [new DateTime(), true],           // date time
            [123456, false],                   // integers
            [123456.123, false],               // floats
            [new \stdClass(), false],          // objects
            [true, false],                     // booleans
        ];
    }

    /**
     * @return array<int, array<int,mixed>>
     */
    public static function values(): array
    {
        return [
            [
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                0,
            ],
            [
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 13:56:11'),
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                1,
            ],
            [
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 12:56:11'),
                DateTime::createFromFormat('Y-m-d H:i:s', '2016-01-01 13:56:11'),
                -1,
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
    public function testCompareValues(mixed $a, mixed $b, mixed $expectedResult): void
    {
        $comparator = new DateTimeComparator();
        $this->assertEquals($expectedResult, $comparator->compare($a, $b));
    }
}
