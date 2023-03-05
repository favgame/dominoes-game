<?php

namespace FavGame\DominoesGame\Round;

use FavGame\DominoesGame\Dice\DiceList;
use FavGame\DominoesGame\Player\PlayerQueue;

interface RoundFactoryInterface
{
    public function createRound(PlayerQueue $queue, DiceList $diceList = null): Round;
}
