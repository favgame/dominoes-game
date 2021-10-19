<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\Id;
use Dominoes\Players\PlayerScoreList;

final class GameEndEvent extends AbstractGameEvent
{
    /** @var string */
    private const EVENT_NAME = 'Game end';

    /**
     * @var PlayerScoreList
     */
    private PlayerScoreList $playerScoreList;

    /**
     * @param Id $id
     * @param GameData $gameData
     * @param PlayerScoreList $playerScoreList
     */
    public function __construct(Id $id, GameData $gameData, PlayerScoreList $playerScoreList)
    {
        $this->playerScoreList = $playerScoreList;

        parent::__construct($id, $gameData, self::EVENT_NAME);
    }

    /**-
     * @return PlayerScoreList
     */
    public function getPlayerScoreList(): PlayerScoreList
    {
        return $this->playerScoreList;
    }
}
