<?php

namespace Dominoes\GameRounds;

use ArrayObject;
use Dominoes\AbstractList;

/**
 * @method ArrayObject|Round[] getItems()
 */
final class RoundList extends AbstractList
{
    /**
     * @param Round $gameRound
     * @return void
     */
    public function addItem(Round $gameRound): void
    {
        $this->items[] = $gameRound;
    }
}
