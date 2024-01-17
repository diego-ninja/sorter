<?php

namespace Ninja\Sorter\Comparator;

final readonly class NumericComparator implements ComparatorInterface
{
    public function __construct(private int $scale = 10) {}

    /**
     * {@inheritdoc}
     */
    public function compare(mixed $a, mixed $b): int
    {
        return bccomp((string)$a, (string)$b, $this->scale);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(mixed $value): bool
    {
        return is_numeric($value);
    }
}
