<?php

namespace Dominoes;

use ArrayObject;

abstract class AbstractList
{
    /**
     * @var array
     */
    protected array $items = [];

    /**
     * @return ArrayObject
     */
    abstract public function getItems(): ArrayObject;

    /**
     * @param callable $callable
     * @return ArrayObject
     */
    protected function filterItems(callable $callable): ArrayObject
    {
        $items = array_filter($this->items);

        return new ArrayObject($items);
    }

    /**
     * @param $item
     * @return bool
     */
    public function isExist($item): bool
    {
        return (array_search($item, $this->items, true) !== null);
    }
}
