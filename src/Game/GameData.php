<?php

namespace FavGame\DominoesGame\Game;

use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Round\Round;
use FavGame\DominoesGame\Round\RoundList;
use FavGame\DominoesGame\Rules\GameRulesInterface;

class GameData
{
    /**
     * @param Round[] $rounds
     */
    public function __construct(
        protected PlayerQueue $queue,
        protected GameRulesInterface $rules,
        protected RoundList $rounds,
        protected GameScore $score,
    ) {
    }
    
    public function getQueue(): PlayerQueue
    {
        return $this->queue;
    }
    
    public function getRules(): GameRulesInterface
    {
        return $this->rules;
    }
    
    public function getScore(): GameScore
    {
        return $this->score;
    }
    
    public function getRounds(): RoundList
    {
        return $this->rounds;
    }
}
