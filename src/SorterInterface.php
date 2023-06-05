<?php

namespace Ninja\Sorter;

interface SorterInterface
{
    public const ASC = 1;
    public const DESC = -1;

    public function sort(array $collection): array;
}
