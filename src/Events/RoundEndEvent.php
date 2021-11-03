<?php

namespace FavGame\DominoesGame\Events;

use DateTimeInterface;
use FavGame\DominoesGame\GameData;
use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\PlayerScores\RoundScoreList;

/**
 * Событие завершения раунда
 */
final class RoundEndEvent extends AbstractGameEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Round end';

    /**
     * @var RoundScoreList Список штрафных очков
     */
    private RoundScoreList $scoreList;

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param GameData $gameData Игровые данные
     * @param RoundScoreList $scoreList Список штрафных очков
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData, RoundScoreList $scoreList)
    {
        $this->scoreList = $scoreList;

        parent::__construct($id, $createdAt, $gameData, self::EVENT_NAME);
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
