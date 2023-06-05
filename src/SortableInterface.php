<?php

namespace Ninja\Sorter;

interface SortableInterface
{
    public function sort(SorterInterface $sorter): self;
}
