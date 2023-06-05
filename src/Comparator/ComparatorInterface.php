<?php

namespace Ninja\Sorter\Comparator;

interface ComparatorInterface
{
    /**
     * Compare a to b
     * Returns -1 if a < b, 0 if a = b and 1 if a > b
     */
    public function compare(mixed $a, mixed $b): int;

    /**
     * Tell if current ComparatorInterface supports given value
     */
    public function supports(mixed $value): bool;
}
