<?php

namespace Ninja\Sorter\Tests\unit\Comparator;

use Ninja\Sorter\Comparator\UnicodeComparator;
use PHPUnit\Framework\TestCase;

class UnicodeComparatorTest extends TestCase
{
    public static function formats(): array
    {
        return array(
            array('zażółć gęślą jaźń', true),       // strings
            array(123456, true),                    // integers
            array(123456.123, true),                // floats
            array(new \stdClass(), false),          // objects
            array(true, false),                     // booleans
        );
    }

    public static function values(): array
    {
        return array(

            array(-1000, -100, 1), // correct
            array(1000, -100, 1),
            array(-100, -100, 0),

            array(-100, -1000, -1), // correct
            array(-100, 1000, -1),

            array(100, 1000, -1),
            array(1000, 100, 1),
            array(100, 100, 0),

            array('-1000', '-100', 1),
            array('-100', '100', -1),
            array('100', '-100', 1),
            array('-100', '-100', 0),
            array('-1', '1', -1),
            array('1', '-1', 1),
            array('-1', '-1', 0),
            array('1', '1', 0),
            array('1', '2', -1),
            array('2', '1', 1),
            array('a', 'a', 0),
            array('a', 'b', -1),
            array('b', 'a', 1),
            array('zażółć gęślą jaźń', 'zażółć gęślą jaźń', 0),
            array('fzażółć gęślą jaźń', 'ęzażółć gęślą jaźń', 1),
            array('ęzażółć gęślą jaźń', 'fzażółć gęślą jaźń', -1),
        );
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
