<?php

namespace Ninja\Sorter\Tests\unit\Strategy;

use Ninja\Sorter\SorterInterface;
use Ninja\Sorter\Strategy\ComplexSortStrategy;
use PHPUnit\Framework\TestCase;

class ObjectSortStrategyTest extends TestCase
{
    public static function dataProvider(): array
    {
        return array(
            array(
            // ---

                array(
                    (object)array('name' => 'Betty', 'position' => '1', 'rating' => '2'),
                    (object)array('name' => 'Ann', 'position' => '2', 'rating' => '1'),
                    (object)array('name' => 'Ann', 'position' => '2', 'rating' => '2'),
                    (object)array('name' => 'Ann', 'position' => '3', 'rating' => '3'),
                ),

                // unsorted
                array(
                    (object)array('name' => 'Ann', 'position' => '3', 'rating' => '3'),
                    (object)array('name' => 'Ann', 'position' => '2', 'rating' => '2'),
                    (object)array('name' => 'Ann', 'position' => '2', 'rating' => '1'),
                    (object)array('name' => 'Betty', 'position' => '1', 'rating' => '2'),
                )
            )

            // ---

        );
    }

    public function testSortComplexDataSet(array $expected, array $unsorted): void
    {

        $strategy = new ComplexSortStrategy();
        $strategy
            ->setOrder(SorterInterface::ASC)
            ->sortBy('position')
            ->sortBy('name')
            ->sortBy('rating')
        ;

        $this->assertEquals($expected, $strategy->sort($unsorted));
    }
}
