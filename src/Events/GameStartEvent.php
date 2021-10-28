<?php

namespace FavGame\Dominoes\Events;

use DateTimeInterface;
use FavGame\Dominoes\GameData;
use FavGame\Dominoes\Id;

/**
 * Событие начала новой игры
 */
final class GameStartEvent extends AbstractGameEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Game start';

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param GameData $gameData Игровые данные
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData)
    {
        parent::__construct($id, $createdAt, $gameData, self::EVENT_NAME);
    }
}
