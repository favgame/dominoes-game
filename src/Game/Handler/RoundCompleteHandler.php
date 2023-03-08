<?php

namespace FavGame\DominoesGame\Game\Handler;

use FavGame\DominoesGame\Event\EventManager;
use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Round\RoundData;
use FavGame\DominoesGame\Round\RoundFactoryInterface;

class RoundCompleteHandler implements RoundHandlerInterface
{
    public function __construct(
        private EventManager $eventManager,
        private RoundFactoryInterface $roundFactory,
    ) {
    }
    
    public function handle(GameData $game, RoundData $round): void
    {
        if ($round->getState()->isComplete()) {
            $game->getScore()->calculateValues($game->getRounds());
            $winnerScore = $game->getScore()->getWinnerScore($game->getRules());
            
            if ($winnerScore) {
                $this->eventManager->dispatchGameEndEvent($game->getScore());
                
                return; // Конец игры
            }
            // Следующий раунд
            $round = $this->roundFactory->createRound($game->getQueue());
            $game->getRounds()->addRound($round);
        }
    }
}
