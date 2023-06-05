<?php

namespace Ninja\Sorter;

use Ninja\Sorter\Comparator\UnicodeCIComparator;
use Ninja\Sorter\Strategy\SimpleSortStrategy;
use Ninja\Sorter\Strategy\StrategyInterface;

abstract class AbstractSorter implements SorterInterface
{
    public function __construct(private ?StrategyInterface $strategy = null)
    {
        if ($this->strategy === null) {
            $this->strategy = new SimpleSortStrategy(new UnicodeCIComparator());
        }
    }

    public function setStrategy(StrategyInterface $strategy): static
    {
        $this->strategy = $strategy;
        return $this;
    }

    public function setSortOrder(int $order): static
    {
        $this->strategy?->setOrder($order);
        return $this;
    }

    public function sort(array $collection): array
    {
        if (!$this->strategy) {
            throw new \RuntimeException('Strategy was not defined');
        }

        return $this->strategy->sort($collection);
    }
}
