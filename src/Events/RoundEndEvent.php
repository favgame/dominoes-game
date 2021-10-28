<?php

namespace FavGame\Dominoes\Events;

use DateTimeInterface;
use FavGame\Dominoes\GameData;
use FavGame\Dominoes\Id;
use FavGame\Dominoes\PlayerScores\ScoreList;

/**
 * Событие завершения раунда
 */
final class RoundEndEvent extends AbstractGameEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Round end';

    /**
     * @var ScoreList Список игровых очков раунда
     */
    private ScoreList $scoreList;

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param GameData $gameData Игровые данные
     * @param ScoreList $scoreList Список игровых очков раунда
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData, ScoreList $scoreList)
    {
        $this->scoreList = $scoreList;

        parent::__construct($id, $createdAt, $gameData, self::EVENT_NAME);
    }

    /**
     * Получить список игровых очков
     *
     * @return ScoreList
     */
    public function getScoreList(): ScoreList
    {
        return $this->scoreList;
    }
}
