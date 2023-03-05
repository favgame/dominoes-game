<?php

namespace FavGame\DominoesGame\Field;

use FavGame\DominoesGame\Dice\Dice;

class Collision
{
    public function __construct(
        private int $value,
        private Dice $diceA,
        private Dice|null $diceB = null,
    ) {
    }
    
    public function getDiceA(): Dice
    {
        return $this->diceA;
    }
    
    public function getDiceB(): Dice|null
    {
        return $this->diceB;
    }
    
    public function hasDiceB(): bool
    {
        return ($this->diceB !== null);
    }
    
    /**
     * @throws InvalidAllocationException
     */
    public function addCollision(Dice $diceB): void
    {
        if (!$this->canAddCollision($diceB)) {
            throw new InvalidAllocationException();
        }
        
        $this->diceB = $diceB;
    }
    
    public function canAddCollision(Dice $dice): bool
    {
        if ($this->hasDiceB() || $this->getDiceA() === $dice || !$dice->getState()->isInHand()) {
            return false;
        }
        
        if ($dice->getSideA() !== $this->getValue() && $dice->getSideB() !== $this->getValue()) {
            return false;
        }
        
        return true;
    }
    
    public function getValue(): int
    {
        return $this->value;
    }
}
