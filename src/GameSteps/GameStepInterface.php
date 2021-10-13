<?php

namespace Dominoes\GameSteps;

use Dominoes\Dices\Dice;
use Dominoes\Players\PlayerInterface;

interface GameStepInterface
{
    public function getPlayer(): PlayerInterface;

    public function getDice(): ?Dice;
}
