<?php

namespace FavGame\DominoesGame\Round;

use FavGame\DominoesGame\Dice\DiceList;
use FavGame\DominoesGame\Field\GameField;

class RoundData
{
    public function __construct(
        protected readonly DiceList $diceList,
        protected readonly RoundScore $score,
        protected readonly GameField $field,
        protected RoundState $state = RoundState::initial,
    ) {
    }
    
    public function getDiceList(): DiceList
    {
        return $this->diceList;
    }
    
    public function getScore(): RoundScore
    {
        return $this->score;
    }
    
    public function getField(): GameField
    {
        return $this->field;
    }
    
    public function getState(): RoundState
    {
        return $this->state;
    }
    
    public function setInProgress(): void
    {
        $this->state = RoundState::inProgress;
    }
    
    public function setComplete(): void
    {
        $this->state = RoundState::complete;
    }
}
