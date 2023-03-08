<?php

namespace FavGame\DominoesGame\Game\Handler;

use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Round\RoundData;

class CompositeRoundHandler implements RoundHandlerInterface
{
    public function __construct(
        private RoundInitialHandler $initialHandler,
        private RoundInProgressHandler $inProgressHandler,
        private RoundCompleteHandler $completeHandler,
    ) {
    }
    
    public function handle(GameData $game, RoundData $round): void
    {
        $this->initialHandler->handle($game, $round);
        $this->inProgressHandler->handle($game, $round);
        $this->completeHandler->handle($game, $round);
        $this->initialHandler->handle($game, $round);
    }
}
