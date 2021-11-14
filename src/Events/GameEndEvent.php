<?php

namespace FavGame\DominoesGame\Events;

use FavGame\DominoesGame\PlayerScores\GameScoreList;

/**
 * Событие завершения игры
 */
final class GameEndEvent extends AbstractEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Game end';

    /**
     * @var GameScoreList Список игровых очков
     */
    private GameScoreList $scoreList;

    /**
     * @param GameScoreList $scoreList Список игровых очков
     */
    public function __construct(GameScoreList $scoreList)
    {
        $this->scoreList = $scoreList;

        parent::__construct(self::EVENT_NAME);
    }

    /**
     * Получить список игровых очков
     *
     * @return GameScoreList
     */
    public function getScoreList(): GameScoreList
    {
        return $this->scoreList;
    }
}
