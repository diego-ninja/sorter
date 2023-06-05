<?php

namespace Ninja\Sorter\Comparator;

use Collator;

class UnicodeComparator implements ComparatorInterface
{
    private Collator $collator;

    public function __construct(?string $locale = null)
    {
        if (!$locale) {
            $locale = \Locale::getDefault();
        }

        $this->collator = new Collator($locale);
        $this->collator->setAttribute(Collator::NUMERIC_COLLATION, Collator::ON);
    }

    public function getLocale(): string
    {
        return $this->collator->getLocale(\Locale::VALID_LOCALE);
    }

    /**
     * {@inheritdoc}
     */
    public function compare(mixed $a, mixed $b): int
    {
        $result = $this->collator->compare($a, $b);
        return $result !== false ? $result : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($value): bool
    {
        return $value === null || is_string($value) || is_int($value) || is_float($value);
    }
}
