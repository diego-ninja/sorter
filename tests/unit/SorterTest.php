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
        $expected = array('20', '1020', 'abc', 'bcd', 'cdb');
        $sortable = array('bcd', 'cdb', '20', 'abc', '1020');

        $sorter = new Sorter();
        $sorted = $sorter->sort($sortable);

        $this->assertEquals($expected, $sorted);
    }

    public function testSortAnArrayOfStringsUsingDefaultSorterInReverseOrder(): void
    {
        $expected = array('e', 'd', 'c', 'b', 'a');
        $sortable = array('a', 'c', 'b', 'e', 'd');

        $sorter = new Sorter();
        $sorter->setSortOrder(SorterInterface::DESC);
        $sorted = $sorter->sort($sortable);

        $this->assertEquals($expected, $sorted);
    }

    public function testSortAnArrayOfStringsUsingDefaultSorterMaintainingKeyAssociation(): void
    {
        $expected = array('k' => '20', -10 => '1020', 194 => 'abc', 10 => 'bcd', 0 => 'cdb');
        $sortable = array(10 => 'bcd', 0 => 'cdb', 'k' => '20', 194 => 'abc', -10 => '1020');

        $sorter = new Sorter();
        $strategy = new SimpleSortStrategy(new UnicodeCIComparator());
        $strategy->setPreserveKeys(true);
        $sorter->setStrategy($strategy);
        $sorted = $sorter->sort($sortable);

        $this->assertEquals($expected, $sorted);
    }
}
