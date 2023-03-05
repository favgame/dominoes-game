<?php

namespace FavGame\DominoesGame\Collection;

use Countable;
use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 */
class Collection implements IteratorAggregate, Countable
{
    /**
     * @param TValue[] $items
     */
    public function __construct(
        protected array $items,
    ) {
    }
    
    /**
     * @return TValue[]|CollectionIterator
     */
    public function getIterator(): CollectionIterator
    {
        return new CollectionIterator($this->items);
    }
    
    public function filter(callable $callback): static
    {
        $collection = clone $this;
        $collection->items = array_filter($this->items, $callback);
        
        return $collection;
    }
    
    public function isEmpty(): bool
    {
        return empty($this->items);
    }
    
    public function count(): int
    {
        return count($this->items);
    }
}
