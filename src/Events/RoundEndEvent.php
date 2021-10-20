<?php

namespace Dominoes\Events;

use Dominoes\Id;
use Dominoes\Players\ScoreList;
use Dominoes\RoundData;

final class RoundEndEvent extends AbstractEvent
{
    use RoundDataTrait;

    /** @var string */
    private const EVENT_NAME = 'Round end';

    /**
     * @var ScoreList
     */
    private ScoreList $scoreList;

    /**
     * @param Id $id
     * @param RoundData $roundData
     * @param ScoreList $scoreList
     */
    public function __construct(Id $id, RoundData $roundData, ScoreList $scoreList)
    {
        $this->roundData = $roundData;
        $this->scoreList = $scoreList;

        parent::__construct($id, self::EVENT_NAME);
    }

    /**-
     * @return ScoreList
     */
    public function getScoreList(): ScoreList
    {
        return $this->scoreList;
    }
}
