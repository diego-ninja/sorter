<?php

namespace Ninja\Sorter\Strategy;

use Ninja\Sorter\Comparator\ComparatorInterface;
use Ninja\Sorter\SorterInterface;

interface StrategyInterface extends SorterInterface
{
    public function setComparator(ComparatorInterface $comparator): self;
    public function setOrder(int $order): self;
    public function setPreserveKeys(bool $preserve_keys): self;
}
