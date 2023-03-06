<?php

namespace FavGame\DominoesGame\Dice;

use FavGame\DominoesGame\Collection\Collection;
use FavGame\DominoesGame\Collection\EmptyCollectionException;
use FavGame\DominoesGame\Player\Player;

/**
 * @implements Collection<int, Dice>
 */
class DiceList extends Collection
{
    /**
     * @return bool
     */
    public function isBankEmpty(): bool
    {
        return empty($this->inBank());
    }
    
    /**
     * @return static|iterable<int, Dice>
     */
    public function inBank(): static|iterable
    {
        return $this->filter(fn (Dice $dice) => $dice->getState()->isInBank());
    }
    
    /**
     * @param Player|null $player
     * @return static|iterable<int, Dice>
     */
    public function inHands(Player $player = null): static|iterable
    {
        if ($player !== null) {
            return $this->filter(fn (Dice $dice) => $dice->getState()->isInHand() && $dice->isOwnedBy($player));
        } else {
            return $this->filter(fn (Dice $dice) => $dice->getState()->isInHand());
        }
    }
    
    /**
     * @return Dice
     */
    public function getFreeDice(): Dice
    {
        $dices = $this->inBank()->getIterator();
    
        if ($dices->count()) {
            return $dices->current();
        }
        
        throw new EmptyCollectionException();
    }
}
