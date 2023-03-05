<?php

namespace FavGame\DominoesGame\Event;

use FavGame\DominoesGame\Dice\Dice;
use FavGame\DominoesGame\Field\GameStep;
use FavGame\DominoesGame\Game\GameScore;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Round\RoundScore;

class GameEvent
{
    private array $data;
    
    public function __construct(
        private GameEventType $type,
        mixed ...$params,
    ) {
        $this->data = $params;
    }
    
    public function getType(): GameEventType
    {
        return $this->type;
    }
    
    public function getPlayer(): Player
    {
        return $this->fetchObject(Player::class);
    }
    
    public function getDice(): Dice
    {
        return $this->fetchObject(Dice::class);
    }
    
    public function getGameStep(): GameStep
    {
        return $this->fetchObject(GameStep::class);
    }
    
    public function getRoundScore(): RoundScore
    {
        return $this->fetchObject(RoundScore::class);
    }
    
    public function getGameScore(): GameScore
    {
        return $this->fetchObject(GameScore::class);
    }
    
    private function fetchObject(string $className): mixed
    {
        foreach ($this->data as $value) {
            if (is_a($value, $className)) {
                return $value;
            }
        }
        
        return false;
    }
}
