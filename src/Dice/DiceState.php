<?php

namespace FavGame\DominoesGame\Dice;

enum DiceState: int
{
    case inBank = 0;
    case inHand = 1;
    case inField = 2;
    
    public function isInBank(): bool
    {
        return ($this === self::inBank);
    }
    
    public function isInHand(): bool
    {
        return ($this === self::inHand);
    }
    
    public function isInField(): bool
    {
        return ($this === self::inField);
    }
}
