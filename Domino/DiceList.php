<?php

namespace Domino\Dices;

use ArrayObject;

final class DiceList
{
    private array $items;

    public function addItem(Dice $dice): void
    {
        $this->items[] = $dice;
    }

    public function getIterator(): ArrayIterrator
    {
        return new ArrayItetator(,);
    }
}
