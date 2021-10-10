<?php

namespace Domino\Dices;

use ArrayObject;

final class DiceList extends AbstractList
{
    public function addItem(Dice $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): ArrayObject
    {
        return new ArrayObject($this->items);
    }

    public function getItemsByOwner(Player $owner): ArrayObject
    {
        $filter = fn (Dice $dice) => $dice->getOwner() === $owner;

        return $this->filterItems($filter);
    }
}
