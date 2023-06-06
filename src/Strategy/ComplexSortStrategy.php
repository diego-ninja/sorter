<?php

/**
 * Copyright (c) 2013 Jacek Kobus <kobus.jacek@gmail.com>
 * See the file LICENSE.txt for copying permission.
 */

namespace Ninja\Sorter\Strategy;

use ArrayAccess;
use Closure;
use Ninja\Sorter\Comparator\ComparatorInterface;
use Ninja\Sorter\Comparator\UnicodeCIComparator;

class ComplexSortStrategy extends AbstractSortStrategy
{
    private array $property_map = [];

    public function __construct(protected ?ComparatorInterface $comparator = null)
    {
        if ($this->comparator === null) {
            $this->comparator = new UnicodeCIComparator();
        }
    }

    public function sortBy(mixed $accessor, int $order = null, ComparatorInterface $comparator = null): static
    {
        $this->property_map[] = array(
            'accessor' => $accessor,
            'direction' => $order ?? $this->getOrder(),
            'comparator' => $comparator ?? $this->getComparator()
        );

        return $this;
    }

    protected function createSortTransformFunction(): Closure
    {
        $propertyMap = $this->property_map;
        $propertyExtractor = $this->getPropertyExtractor();
        $valueChecker = $this->getValueChecker();

        return static function (mixed $a, mixed $b) use ($propertyMap, $propertyExtractor, $valueChecker) {

            foreach ($propertyMap as $property) {
                $valueA = $propertyExtractor($a, $property['accessor']);
                $valueB = $propertyExtractor($b, $property['accessor']);

                $cmp = $property['comparator'];
                $valueChecker($valueA, $valueB, $cmp);
                $result = $cmp->compare($valueA, $valueB);

                if ($result !== 0) {
                    return $result * $property['direction'];
                }
            }

            return 0;
        };
    }

    /**
     * Get callable used for extracting values from sortable entities (objects, arrays etc.)
     * This method extracts value from k, where k is an element of collection(i => k).
     * Accessor can be customized to add sorting ability to a complex objects.
     *
     * @return Closure Takes two arguments, $property and $accessor
     */
    private function getPropertyExtractor(): Closure
    {
        return static function (mixed $property, mixed $accessor = null): mixed {

            if (is_string($property) || !$accessor) {
                return $property;
            }

            if ($accessor instanceof Closure) {
                return $accessor($property);
            }

            if (is_string($accessor)) {
                if (is_array($property) || $property instanceof ArrayAccess) {
                    return $property[$accessor];
                }

                if (is_object($property) && property_exists($property, $accessor)) {
                    return $property->$accessor;
                }
            }

            throw new \RuntimeException(sprintf('Unable to resolve property value: %s', gettype($property)));
        };
    }

    public function sort(array $collection): array
    {
        if (empty($this->property_map)) {
            throw new \RuntimeException('Missing sort properties - add them using sortBy(...)');
        }

        return parent::sort($collection);
    }
}
