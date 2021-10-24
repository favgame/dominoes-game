<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\Id;
use Dominoes\PlayerScores\ScoreList;

final class RoundEndEvent extends AbstractGameEvent
{
    /** @var string */
    private const EVENT_NAME = 'Round end';

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
        $this->scoreList = $scoreList;

        parent::__construct($id, $gameData, self::EVENT_NAME);
    }

    /**-
     * @return ScoreList
     */
    public function getScoreList(): ScoreList
    {
        return $this->scoreList;
    }
}
