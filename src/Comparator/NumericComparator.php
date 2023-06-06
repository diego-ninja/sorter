<?php

namespace Ninja\Sorter\Comparator;

final class NumericComparator implements ComparatorInterface
{
    public function __construct(private readonly int $scale = 10)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function compare(mixed $a, mixed $b): int
    {
        return bccomp((string) $a, (string) $b, $this->scale);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($value): bool
    {
        return is_numeric($value) || is_int($value) || is_float($value);
    }
}
