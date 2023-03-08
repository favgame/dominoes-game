<?php

namespace FavGame\DominoesGame\Round;

use FavGame\DominoesGame\Collection\Collection;
use FavGame\DominoesGame\Collection\EmptyCollectionException;

/**
 * @implements Collection<int, Round>
 */
class RoundList extends Collection
{
    /**
     * @throws InvalidStateException
     */
    public function addRound(Round $round): void
    {
        $previous = end($this->items);
        
        if ($previous && !$previous->getState()->isComplete()) {
            throw new InvalidStateException();
        }
        
        if (!$round->getState()->isInitial()) {
            throw new InvalidStateException();
        }
        
        $this->items[] = $round;
    }
    
    /**
     * @throws EmptyCollectionException
     */
    public function getCurrent(): Round
    {
        $round = end($this->items);
        
        if ($round) {
            return $round;
        }
        
        throw new EmptyCollectionException();
    }
}
