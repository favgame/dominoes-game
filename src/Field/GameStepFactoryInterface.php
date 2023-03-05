<?php

namespace FavGame\DominoesGame\Field;

use FavGame\DominoesGame\Dice\Dice;

interface GameStepFactoryInterface
{
    public function createGameStep(Dice $dice, Collision|null $collision): GameStep;
    
    public function createGameStepList(array $steps): GameStepList;
}
