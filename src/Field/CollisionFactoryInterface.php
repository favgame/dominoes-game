<?php

namespace FavGame\DominoesGame\Field;

use FavGame\DominoesGame\Dice\Dice;

interface CollisionFactoryInterface
{
    public function createCollision(int $value, Dice $diceA, Dice $diceB = null): Collision;
}
