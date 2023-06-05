<?php

namespace Ninja\Sorter\Strategy;

use Closure;
use Ninja\Sorter\Comparator\ComparatorInterface;
use Ninja\Sorter\Comparator\UnicodeCIComparator;
use RuntimeException;

abstract class AbstractSortStrategy implements StrategyInterface
{
    private bool $preserve_keys = false;

    public function __construct(protected ?ComparatorInterface $comparator, private int $order = self::ASC)
    {
        if ($this->comparator === null) {
            $this->comparator = new UnicodeCIComparator();
        }
    }

    public function setComparator(ComparatorInterface $comparator): self
    {
        $this->comparator = $comparator;

        return $this;
    }

    protected function getComparator(): ?ComparatorInterface
    {
        return $this->comparator;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    protected function getOrder(): int
    {
        return $this->order;
    }

    public function setPreserveKeys(bool $preserve_keys): self
    {
        $this->preserve_keys = $preserve_keys;
        return $this;
    }

    /**
     * @return Closure
     */
    protected function createSortTransformFunction(): Closure
    {
        $comparator = $this->getComparator();
        $checker = $this->getValueChecker();
        $sortOrder = $this->order;

        return static function (mixed $a, mixed $b) use ($comparator, $checker, $sortOrder) {
            $checker($a, $b, $comparator);
            return $comparator->compare($a, $b) * $sortOrder;
        };
    }

    public function sort(array $collection): array
    {
        $function = $this->preserve_keys ? 'uasort' : 'usort';
        $function($collection, $this->createSortTransformFunction());

        return $collection;
    }

    protected function getValueChecker(): Closure
    {
        return static function (mixed $a, mixed $b, ComparatorInterface $comparator) {
            $exceptionMessage = 'Comparator (%s) does not support "%s"';

            $error = null;
            if (!$comparator->supports($a)) {
                $error = sprintf($exceptionMessage, get_class($comparator), gettype($a));
            } elseif (!$comparator->supports($b)) {
                $error = sprintf($exceptionMessage, get_class($comparator), gettype($a));
            }

            if ($error !== null) {
                throw new RuntimeException($error);
            }
        };
    }
}
