<?php

namespace Dominoes\Dices;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Players\PlayerInterface;

/**
 * @method ArrayObject|Dice[] getItems()
 */
final class DiceList extends AbstractList
{
    /**
     * @param PlayerInterface $owner
     * @return ArrayObject|Dice[]
     */
    public function getItemsByOwner(PlayerInterface $owner): ArrayObject
    {
        $callback = fn (Dice $dice) => ($dice->getOwner() === $owner && !$dice->isUsed());

        return $this->filterItems($callback);
    }

    /**
     * @return Dice|null
     */
    public function getFreeItem(): ?Dice
    {
        $items = $this->filterItems(fn (Dice $dice) => !$dice->hasOwner());

        if ($items->count()) {
            return $items[array_rand((array) $items)];
        }

        return null;
    }

    /**
     * @return ArrayObject|Dice[]
     */
    public function getActiveItems(): ArrayObject
    {
        return $this->filterItems(fn (Dice $dice) => $dice->isUsed());
    }
}
