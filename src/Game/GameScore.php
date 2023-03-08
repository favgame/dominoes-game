<?php

namespace FavGame\DominoesGame\Game;

use FavGame\DominoesGame\Collection\Collection;
use FavGame\DominoesGame\Player\PlayerScore;
use FavGame\DominoesGame\Round\RoundList;
use FavGame\DominoesGame\Rules\GameRulesInterface;

/**
 * @implements Collection<int, PlayerScore>
 */
class GameScore extends Collection
{
    public function calculateValues(RoundList $rounds): void
    {
        foreach ($this as $playerScore) {
            $points = 0;
            $scores = 0;
            
            foreach ($rounds as $round) {
                $scores += $round->getScore()->getPlayerScore($playerScore->getPlayer())->getScore();
                $points += $round->getScore()->getPlayerScore($playerScore->getPlayer())->getPoints();
            }
            
            $playerScore->setScore($scores);
            $playerScore->setPoints($points);
        }
    }
    
    public function getWinnerScore(GameRulesInterface $rules): ?PlayerScore
    {
        $playerScore = $this->getBestScore();
        
        if ($playerScore && $playerScore->getScore() >= $rules->getMaxScoreAmount()) {
            return $playerScore;
        }
        
        return null;
    }
    
    private function getBestScore(): ?PlayerScore
    {
        $score = [];
    
        foreach ($this as $i => $playerScore) {
            $score[$playerScore->getScore()][$i] = $playerScore;
        }
        
        ksort($score);
        $result = end($score);
        
        if (is_array($result) && count($score) === 1) {
            return reset($result);
        }
        
        return null;
    }
}
