<?php

namespace Dominoes\Dices;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

final class DiceList extends AbstractList
{
    /**
     * @param int $maxSideValue
     * @return self
     */
    public static function createInstance(int $maxSideValue): self
    {
        $list = new self();

        for ($sideB = 0; $sideB <= $maxSideValue; $sideB++) {
            for ($sideA = 0; $sideA <= $sideB; $sideA++) {
                $item = new Dice(Id::next(), new DiceSide($sideB), new DiceSide($sideA));
                $list->addItem($item);
            }
        }

        return $list;
    }

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
