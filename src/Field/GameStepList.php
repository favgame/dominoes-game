<?php

namespace FavGame\DominoesGame\Field;

use FavGame\DominoesGame\Collection\Collection;
use FavGame\DominoesGame\Collection\EmptyCollectionException;

/**
 * @implements Collection<int, GameStep>
 */
class GameStepList extends Collection
{
    /**
     * @throws EmptyCollectionException
     */
    public function getStepWithMinPoints(): GameStep
    {
        return $this->getStepWithBestPoints()[0];
    }
    
    /**
     * @throws EmptyCollectionException
     */
    public function getStepWithMaxPoints(): GameStep
    {
        return $this->getStepWithBestPoints()[1];
    }
    
    /**
     * @throws EmptyCollectionException
     */
    private function getStepWithBestPoints(): array
    {
        $min = null;
        $max = null;
        
        if ($this->count() < 1) {
            throw new EmptyCollectionException();
        }
        
        foreach ($this as $step) {
            if ($min === null || $step->getDice()->getPoints() < $min->getDice()->getPoints()) {
                $min = $step;
            }
            
            if ($max === null || $step->getDice()->getPoints() > $max->getDice()->getPoints()) {
                $max = $step;
            }
        }
        
        return [$min, $max];
    }
}
