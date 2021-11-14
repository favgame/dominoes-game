<?php

namespace FavGame\DominoesGame\Events;

use FavGame\DominoesGame\PlayerScores\RoundScoreList;

/**
 * Событие завершения раунда
 */
final class RoundEndEvent extends AbstractEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Round end';

    /**
     * @var RoundScoreList Список штрафных очков
     */
    private RoundScoreList $scoreList;

    /**
     * @param RoundScoreList $scoreList Список штрафных очков
     */
    public function __construct(RoundScoreList $scoreList)
    {
        $this->scoreList = $scoreList;

        parent::__construct(self::EVENT_NAME);
    }

    /**
     * Получить список игровых очков
     *
     * @return RoundScoreList
     */
    public function getScoreList(): RoundScoreList
    {
        return $this->scoreList;
    }
}
