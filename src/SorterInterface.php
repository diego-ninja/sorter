<?php

namespace Ninja\Sorter;

interface SorterInterface
{
    public const ASC  = 1;
    public const DESC = -1;

    /**
     * @param array<string|int, mixed> $collection
     * @return array<string|int, mixed>
     */
    public function sort(array $collection): array;
}
