<?php

namespace Ninja\Sorter\Comparator;

use DateTimeInterface;

final readonly class DateTimeComparator implements ComparatorInterface
{
    public function compare(mixed $a, mixed $b): int
    {
        if ($a > $b) {
            return 1;
        }

        if ($a < $b) {
            return -1;
        }

        return 0;
    }

    public function supports(mixed $value): bool
    {
        return $value instanceof DateTimeInterface;
    }
}
