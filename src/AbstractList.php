<?php

namespace Dominos;

abstract class AbstractList
{
    protected array $items;

    abstract public function getItems(): ArrayObject;

    protected function filterItems(callable $callable): ArrayObject
    {
        $items = array_filter($this->items);

        return new ArrayObject($items);
    }
}
