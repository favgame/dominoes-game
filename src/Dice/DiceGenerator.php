<?php

namespace FavGame\DominoesGame\Dice;

use FavGame\DominoesGame\Rules\GameRulesInterface;

class DiceGenerator
{
    public function __construct(
        private GameRulesInterface $gameRules,
    ) {
    }
    
    public function generateItems(): array
    {
        $items = [];
        
        for ($sideB = 0; $sideB <= $this->gameRules->getMaxSideValue(); $sideB++) {
            for ($sideA = 0; $sideA <= $sideB; $sideA++) {
                $items[] = [$sideA, $sideB];
            }
        }
        
        return $items;
    }
}
