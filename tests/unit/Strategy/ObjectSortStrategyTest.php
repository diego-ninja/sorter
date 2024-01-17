<?php

namespace Ninja\Sorter\Tests\unit\Strategy;

use Ninja\Sorter\SorterInterface;
use Ninja\Sorter\Strategy\ComplexSortStrategy;
use PHPUnit\Framework\TestCase;

class ObjectSortStrategyTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            [
                // ---

                [
                    (object)['name' => 'Betty', 'position' => '1', 'rating' => '2'],
                    (object)['name' => 'Ann', 'position' => '2', 'rating' => '1'],
                    (object)['name' => 'Ann', 'position' => '2', 'rating' => '2'],
                    (object)['name' => 'Ann', 'position' => '3', 'rating' => '3'],
                ],

                // unsorted
                [
                    (object)['name' => 'Ann', 'position' => '3', 'rating' => '3'],
                    (object)['name' => 'Ann', 'position' => '2', 'rating' => '2'],
                    (object)['name' => 'Ann', 'position' => '2', 'rating' => '1'],
                    (object)['name' => 'Betty', 'position' => '1', 'rating' => '2'],
                ],
            ],

            // ---

        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSortComplexDataSet(array $expected, array $unsorted): void
    {

        $strategy = new ComplexSortStrategy();
        $strategy
            ->setOrder(SorterInterface::ASC)
            ->sortBy('position')
            ->sortBy('name')
            ->sortBy('rating');

        $this->assertEquals($expected, $strategy->sort($unsorted));
    }
}
