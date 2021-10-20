<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\Id;
use Dominoes\Players\ScoreList;

final class GameEndEvent extends AbstractEvent
{
    /** @var string */
    private const EVENT_NAME = 'Game end';

    /**
     * @var GameData
     */
    private GameData $gameData;

    /**
     * @var ScoreList
     */
    private ScoreList $scoreList;

    /**
     * @param Id $id
     * @param GameData $gameData
     * @param ScoreList $scoreList
     */
    public function __construct(Id $id, GameData $gameData, ScoreList $scoreList)
    {
        $this->gameData = $gameData;
        $this->scoreList = $scoreList;

        parent::__construct($id, self::EVENT_NAME);
    }

    /**
     * @return GameData
     */
    public function getGameData(): GameData
    {
        return $this->gameData;
    }

    /**
     * @return ScoreList
     */
    public function getScoreList(): ScoreList
    {
        return $this->scoreList;
    }
}
