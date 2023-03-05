<?php

namespace FavGame\DominoesGame\Game\Handler;

use FavGame\DominoesGame\Event\EventManager;
use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Game\GameScore;
use FavGame\DominoesGame\Player\PlayerScore;
use FavGame\DominoesGame\Round\RoundData;
use FavGame\DominoesGame\Round\RoundFactoryInterface;
use FavGame\DominoesGame\Round\RoundList;
use FavGame\DominoesGame\Rules\GameRulesInterface;

class RoundCompleteHandler extends AbstractRoundHandler
{
    public function __construct(
        private EventManager $eventManager,
        private RoundFactoryInterface $roundFactory,
    ) {
    }
    
    public function handle(GameData $game, RoundData $round): void
    {
        if ($round->getState()->isComplete()) {
            $this->updateGameScore($game->getScore(), $game->getRounds());
            $winnerScore = $this->getWinnerScore($game->getScore(), $game->getRules());
            
            if ($winnerScore) {
                $this->eventManager->dispatchGameEndEvent($game->getScore());
                return; // Конец игры
            }
            // Следующий раунд
            $round = $this->roundFactory->createRound($game->getQueue());
            $game->getRounds()->addRound($round);
            $this->handleNext($game, $round);
        }
    }
    
    private function updateGameScore(GameScore $score, RoundList $rounds): void
    {
        $score->calculateValues($rounds);
    }
    
    private function getWinnerScore(GameScore $score, GameRulesInterface $rules): ?PlayerScore
    {
        $playerScore = $score->getBestScore();
        
        if ($playerScore && $playerScore->getScore() >= $rules->getMaxScoreAmount()) {
            return $playerScore;
        }
        
        return null;
    }
}
