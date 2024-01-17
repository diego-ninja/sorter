<?php

namespace Ninja\Sorter\Comparator;

final readonly class UnicodeCIComparator extends UnicodeComparator
{
    /**
     * {@inheritdoc}
     */
    public function compare(mixed $a, mixed $b): int
    {
        return parent::compare($this->filter($a), $this->filter($b));
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function filter(string $value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }
}
