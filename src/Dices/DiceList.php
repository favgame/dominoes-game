<?php

namespace Dominoes\Dices;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Players\PlayerInterface;

final class DiceList extends AbstractList
{
    /**
     * @param Dice $item
     * @return void
     */
    public function addItem(Dice $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return ArrayObject|Dice[]
     */
    public function getItems(): ArrayObject
    {
        return new ArrayObject($this->items);
    }

    /**
     * @param PlayerInterface $owner
     * @return ArrayObject|Dice[]
     */
    public function getItemsByOwner(PlayerInterface $owner): ArrayObject
    {
        $callback = fn (Dice $dice) => $dice->getOwner() === $owner;

        return $this->filterItems($callback);
    }

    /**
     * @return ArrayObject|Dice[]
     */
    public function getOwnedItems(): ArrayObject
    {
        return $this->filterItems(fn (Dice $dice) => $dice->hasOwner());
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
