<?php

namespace FavGame\DominoesGame\Round;

use FavGame\DominoesGame\Collection\Collection;
use FavGame\DominoesGame\Dice\DiceList;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerScore;
use InvalidArgumentException;

/**
 * @implements Collection<int, PlayerScore>
 */
class RoundScore extends Collection
{
    public function calculateValues(DiceList $diceList, Player|null $winner): void
    {
        $this->calculatePoints($diceList);
        $this->calculateScore($winner);
    }
    
    public function getPlayerScore(Player $player): PlayerScore
    {
        foreach ($this as $playerScore) {
            if ($player === $playerScore->getPlayer()) {
                return $playerScore;
            }
        }
        
        throw new InvalidArgumentException('Invalid player');
    }
    
    private function calculateScore(Player|null $winner): void
    {
        $winnerScore = $winner ? $this->getPlayerScore($winner) : $this->getBestPoints();
        $score = 0;
        
        foreach ($this as $playerScore) {
            if (!$winnerScore) {
                return;
            }
            
            if ($playerScore !== $winnerScore) {
                $score += $playerScore->getPoints();
            }
        }
    
        $winnerScore->setScore($score);
    }
    
    private function getBestPoints(): ?PlayerScore
    {
        $bestPoints = null;
        
        foreach ($this as $playerScore) {
            if ($bestPoints === null || $bestPoints->getPoints() > $playerScore->getPoints()) {
                $bestPoints = $playerScore;
            }
        }
    
        foreach ($this as $playerScore) {
            if ($bestPoints !== null) {
                if ($bestPoints->getPoints() == $playerScore->getPoints() && $bestPoints !== $playerScore) {
                    return null; // Multiple winners
                }
            }
        }
        
        return $bestPoints;
    }
    
    private function calculatePoints(DiceList $diceList): void
    {
        foreach ($this as $playerScore) {
            $points = 0;
            
            foreach ($diceList->inHands($playerScore->getPlayer()) as $dice) {
                $points += $dice->getPoints();
            }
            
            $playerScore->setPoints($points);
        }
    }
}
