<?php

namespace Dominoes\Dices;

use Dominoes\Id;

final class DiceListFactory
{
    /**
     * @param int $maxSideValue
     * @return DiceList
     */
    public function createDiceList(int $maxSideValue): DiceList
    {
        $list = new DiceList();

        for ($sideB = 0; $sideB <= $maxSideValue; $sideB++) {
            for ($sideA = 0; $sideA <= $sideB; $sideA++) {
                $item = new Dice(Id::next(), new DiceSide($sideB), new DiceSide($sideA));
                $list->addItem($item);
            }
        }

        return $list;
    }
}
