<?php

namespace FavGame\DominoesGame\Collection;

use Countable;
use Iterator;

/**
 * @template TValue
 */
class CollectionIterator implements Iterator, Countable
{
    private int $position = 0;
    
    private int $count = 0;
    
    /**
     * @var int[]
     */
    private array $keys = [];
    
    /**
     * @var TValue[]
     */
    private array $values = [];
    
    public function __construct(
        iterable $items,
    ) {
        foreach ($items as $key => $value) {
            $this->keys[] = $key;
            $this->values[] = $value;
            $this->count++;
        }
    }
    
    public function rewind(): void
    {
        $this->position = 0;
    }
    
    public function valid(): bool
    {
        return (isset($this->keys[$this->position]));
    }
    
    public function key(): int
    {
        return $this->position;
    }
    
    public function current(): mixed
    {
        return $this->values[$this->position];
    }
    
    public function next(): void
    {
        $this->position++;
    }
    
    public function count(): int
    {
        return $this->count;
    }
}
