<?php

namespace FavGame\DominoesGame\Game\Handler;

use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Round\RoundData;
use LogicException;

interface RoundHandlerInterface
{
    /**
     * @throws LogicException
     */
    public function handle(GameData $game, RoundData $round): void;
    
    public function setNext(self $roundHandler): void;
}
