<?php

namespace FavGame\DominoesGame\Dice;

use FavGame\DominoesGame\Player\Player;
use LogicException;
use RangeException;

class Dice
{
    public function __construct(
        private int $sideA,
        private int $sideB,
        private DiceState $state = DiceState::inBank,
        private Player|null $owner = null,
    ) {
        if ($this->sideA > $this->sideB) {
            throw new RangeException('Invalid side value');
        }
    }
    
    public function getSideA(): int
    {
        return $this->sideA;
    }
    
    public function getSideB(): int
    {
        return $this->sideB;
    }
    
    public function getPoints(): int
    {
        return $this->sideA + $this->sideB;
    }
    
    public function getState(): DiceState
    {
        return $this->state;
    }
    
    public function getOwner(): Player|null
    {
        return $this->owner;
    }
    
    public function hasOwner(): bool
    {
        return ($this->owner !== null);
    }
    
    public function isOwnedBy(Player $player): bool
    {
        return ($this->owner === $player);
    }
    
    /**
     * @throws LogicException
     */
    public function distributeToPlayer(Player $player): void
    {
        if ($this->state !== DiceState::inBank) {
            throw new LogicException('Invalid dice state');
        }
        
        $this->owner = $player;
        $this->state = DiceState::inHand;
    }
    
    /**
     * @throws LogicException
     */
    public function putOnField(): void
    {
        if ($this->state !== DiceState::inHand) {
            throw new LogicException('Invalid dice state');
        }
        
        $this->state = DiceState::inField;
    }
}
