<?php

namespace Ninja\Sorter\Tests\unit\Comparator;

use Ninja\Sorter\Comparator\UnicodeComparator;
use PHPUnit\Framework\TestCase;

class UnicodeComparatorTest extends TestCase
{
    /**
     * @return array<int, array<int,mixed>>
     */
    public static function formats(): array
    {
        return [
            ['zażółć gęślą jaźń', true],       // strings
            [123456, true],                    // integers
            [123456.123, true],                // floats
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

            [-1000, -100, 1], // correct
            [1000, -100, 1],
            [-100, -100, 0],

            [-100, -1000, -1], // correct
            [-100, 1000, -1],

            [100, 1000, -1],
            [1000, 100, 1],
            [100, 100, 0],

            ['-1000', '-100', 1],
            ['-100', '100', -1],
            ['100', '-100', 1],
            ['-100', '-100', 0],
            ['-1', '1', -1],
            ['1', '-1', 1],
            ['-1', '-1', 0],
            ['1', '1', 0],
            ['1', '2', -1],
            ['2', '1', 1],
            ['a', 'a', 0],
            ['a', 'b', -1],
            ['b', 'a', 1],
            ['zażółć gęślą jaźń', 'zażółć gęślą jaźń', 0],
            ['fzażółć gęślą jaźń', 'ęzażółć gęślą jaźń', 1],
            ['ęzażółć gęślą jaźń', 'fzażółć gęślą jaźń', -1],
        ];
    }

    public function testCreateNewUnicodeComparatorInstanceWithoutLocaleReturnsInstanceWithDefaultSystemLocale(): void
    {
        $comparator = new UnicodeComparator();

        $this->assertEquals($comparator->getLocale(), \Locale::getDefault());
    }

    public function testCreateNewUnicodeComparatorInstanceWithLocaleReturnsInstanceWithThatLocale(): void
    {
        $comparator = new UnicodeComparator('pl');

        $this->assertEquals('pl', $comparator->getLocale());
    }

    /**
     * @dataProvider formats
     */
    public function testSupportedFormats(mixed $value, bool $is_supported): void
    {
        $comparator = new UnicodeComparator();
        $this->assertSame($is_supported, $comparator->supports($value));
    }

    /**
     * @dataProvider values
     */
    public function testCompareValues(mixed $a, mixed $b, mixed $expectedResult): void
    {
        $comparator = new UnicodeComparator('pl_PL');
        $this->assertEquals($expectedResult, $comparator->compare($a, $b));
    }
}
