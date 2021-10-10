<?php

namespace Dominos\Dices;

use ArrayObject;
use Dominos\AbstractList;
use Dominos\Players\PlayerInterface;

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

    public function getItemsByOwner(PlayerInterface $owner): ArrayObject
    {
        $callback = fn (Dice $dice) => $dice->getOwner() === $owner;

        return $this->filterItems($callback);
    }
}
