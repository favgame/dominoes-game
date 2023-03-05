<?php

namespace FavGame\DominoesGame\Player;

class PlayerScore
{
    public function __construct(
        private Player $player,
        private int $score = 0,
        private int $points = 0,
    ) {
    }
    
    public function getPlayer(): Player
    {
        return $this->player;
    }
    
    public function getScore(): int
    {
        return $this->score;
    }
    
    public function setScore(int $score): void
    {
        $this->score = $score;
    }
    
    public function getPoints(): int
    {
        return $this->points;
    }
    
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }
}
