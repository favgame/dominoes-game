<?php

namespace Dominoes\GameRounds;

use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;
use InfiniteIterator;

/**
 * @method PlayerInterface current()
 */
final class PlayerQueue extends InfiniteIterator
{
    /**
     * @param PlayerList $playerList
     */
    public function __construct(PlayerList $playerList)
    {
        parent::__construct($playerList->getItems()->getIterator());
    }
}
