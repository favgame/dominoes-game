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
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return ArrayObject
     */
    public function getItems(): ArrayObject
    {
        return new ArrayObject($this->items);
    }

    /**
     * @param callable $callable
     * @return ArrayObject
     */
    protected function filterItems(callable $callable): ArrayObject
    {
        $items = array_filter($this->items, $callable);

        return new ArrayObject($items);
    }

    /**
     * @param mixed $item
     * @return bool
     */
    public function hasItem($item): bool
    {
        return (array_search($item, $this->items, true) !== null);
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function eachItems(callable $callback): void
    {
        array_walk($this->items, $callback);
    }
}