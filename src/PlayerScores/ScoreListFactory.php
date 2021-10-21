<?php

namespace Dominoes\PlayerScores;

use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;
use Dominoes\Players\ScoreList;

/**
 * @deprecated
 */
final class ScoreListFactory
{
    /**
     * @var PlayerList
     */
    private PlayerList $playerList;

    /**
     * @param PlayerList $playerList
     */
    public function __construct(PlayerList $playerList)
    {
        $this->playerList = $playerList;
    }

    /**
     * @return ScoreList
     */
    public function createList(): ScoreList
    {
        $items = array_map(fn (PlayerInterface $player) => new Score($player), $this->playerList->getItems());

        return new ScoreList($items);
    }
}
