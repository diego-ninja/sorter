<?php

namespace Ninja\Sorter\Tests\unit;

use Ninja\Sorter\Comparator\UnicodeCIComparator;
use Ninja\Sorter\Sorter;
use Ninja\Sorter\SorterInterface;
use Ninja\Sorter\Strategy\SimpleSortStrategy;
use PHPUnit\Framework\TestCase;

class SorterTest extends TestCase
{
    public function testSortAnArrayOfStringsUsingDefaultSorter(): void
    {
        $expected = ['20', '1020', 'abc', 'bcd', 'cdb'];
        $sortable = ['bcd', 'cdb', '20', 'abc', '1020'];

        $sorter = new Sorter();
        $sorted = $sorter->sort($sortable);

        $this->assertEquals($expected, $sorted);
    }

    public function testSortAnArrayOfStringsUsingDefaultSorterInReverseOrder(): void
    {
        $expected = ['e', 'd', 'c', 'b', 'a'];
        $sortable = ['a', 'c', 'b', 'e', 'd'];

        $sorter = new Sorter();
        $sorter->setSortOrder(SorterInterface::DESC);
        $sorted = $sorter->sort($sortable);

        $this->assertEquals($expected, $sorted);
    }

    public function testSortAnArrayOfStringsUsingDefaultSorterMaintainingKeyAssociation(): void
    {
        $expected = ['k' => '20', -10 => '1020', 194 => 'abc', 10 => 'bcd', 0 => 'cdb'];
        $sortable = [10 => 'bcd', 0 => 'cdb', 'k' => '20', 194 => 'abc', -10 => '1020'];

        $sorter   = new Sorter();
        $strategy = new SimpleSortStrategy(new UnicodeCIComparator());
        $strategy->setPreserveKeys(true);
        $sorter->setStrategy($strategy);
        $sorted = $sorter->sort($sortable);

        $this->assertEquals($expected, $sorted);
    }
}
