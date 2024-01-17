<?php

namespace Ninja\Sorter\Tests\unit\Comparator;

use Ninja\Sorter\Comparator\NumericComparator;
use PHPUnit\Framework\TestCase;

class NumericComparatorTest extends TestCase
{
    /**
     * @return array<int, array<int,mixed>>
     */
    public static function formats(): array
    {
        return [
            [123456, true],                   // integers
            [123456.123, true],               // floats
            [new \DateTime(), false],         // date time
            [new \stdClass(), false],         // objects
            [true, false],                    // booleans
        ];
    }

    /**
     * @return array<int, array<int,mixed>>
     */
    public static function values(): array
    {
        return [
            [-1000, -100, -1],
            [1000, -100, 1],
            [-100, -100, 0],

            [-100, -1000, 1],
            [-100, 1000, -1],

            [100, 1000, -1],
            [1000, 100, 1],
            [100, 100, 0],

            ['100.00', '100.00', 0],
            ['101.00', '100.00', 1],
            ['101.00', '-100.00', 1],
            ['100.00', '101.00', -1],
            ['-100.00', '101.00', -1],

            ['100', '100', 0],
        ];
    }

    /**
     * @dataProvider formats
     */
    public function testSupportedFormats(mixed $value, mixed $is_supported): void
    {
        $comparator = new NumericComparator();
        $this->assertSame($is_supported, $comparator->supports($value));
    }

    /**
     * @dataProvider values
     */
    public function testCompareValues(mixed $a, mixed $b, mixed $expectedResult): void
    {
        $comparator = new NumericComparator();
        $this->assertEquals($expectedResult, $comparator->compare($a, $b));
    }
}
