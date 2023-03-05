<?php

namespace FavGame\DominoesGame\Field;

use FavGame\DominoesGame\Dice\Dice;

class GameStep
{
    public function __construct(
        private Dice $dice,
        private Collision|null $target,
    ) {
    }
    
    public function getDice(): Dice
    {
        return $this->dice;
    }
    
    public function getTarget(): Collision
    {
        return $this->target;
    }
    
    public function hasTarget(): bool
    {
        return ($this->target !== null);
    }
}
