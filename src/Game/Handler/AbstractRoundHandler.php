<?php

namespace FavGame\DominoesGame\Game\Handler;

use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Round\RoundData;

abstract class AbstractRoundHandler implements RoundHandlerInterface
{
    private RoundHandlerInterface|null $nextHandler = null;
    
    public final function setNext(RoundHandlerInterface $roundHandler): void
    {
        $this->nextHandler = $roundHandler;
    }
    
    protected function handleNext(GameData $game, RoundData $round): void
    {
        if ($this->nextHandler !== null) {
            $this->nextHandler->handle($game, $round);
        }
    }
}
