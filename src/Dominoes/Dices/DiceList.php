<?php

namespace Dominoes\Dices;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

/**
 * @method ArrayObject|Dice[] getItems()
 */
final class DiceList extends AbstractList
{
    /**
     * @param RulesInterface $gameRules
     */
    public function __construct(RulesInterface $gameRules)
    {
        $items = [];

        for ($sideB = 0; $sideB <= $gameRules->getMaxSideValue(); $sideB++) {
            for ($sideA = 0; $sideA <= $sideB; $sideA++) {
                $items[] = new Dice(Id::next(), new DiceSide($sideB), new DiceSide($sideA));
            }
        }

        parent::__construct($items);
    }

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

    /**
     * @return Dice|null
     */
    public function getStartItem(): ?Dice
    {
        $dice = null;
        $maxPointAmount = 0;

        foreach ($this->getItems() as $item) {
            if ($item->hasOwner() && $item->getPointAmount() >= $maxPointAmount) {
                $maxPointAmount = $item->getPointAmount();
                $dice = $item;
            }
        }

        return $dice;
    }
}
