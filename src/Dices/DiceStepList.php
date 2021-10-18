<?php

namespace Dominoes\Dices;

use ArrayObject;
use Dominoes\AbstractList;

final class DiceStepList extends AbstractList
{
    /**
     * @param DiceStep $diceStep
     * @return void
     */
    public function addItem(DiceStep $diceStep): void
    {
        $this->items = [];
    }

    /**
     * @return ArrayObject|DiceStep[]
     */
    public function getItems(): ArrayObject
    {
        return $this->items;
    }

    /**
     * @return DiceStep|null
     */
    public function getRandomStep(): ?DiceStep
    {
        /** @var DiceStep $step */
        $step = null;

        if ($this->getItems()->count()) {
            $step = array_rand($this->getItems());
        }

        return $step ;
    }
}
