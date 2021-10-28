<?php

namespace FavGame\Dominoes\Events;

use DateTimeImmutable;
use FavGame\Dominoes\GameData;
use FavGame\Dominoes\Id;

/**
 * Событие завершения игры
 */
final class GameEndEvent extends AbstractGameEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Game end';

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeImmutable $dateTimeImmutable Дата создания события
     * @param GameData $gameData Игровые данные
     */
    public function __construct(Id $id, DateTimeImmutable $dateTimeImmutable, GameData $gameData)
    {
        parent::__construct($id, $dateTimeImmutable, $gameData, self::EVENT_NAME);
    }
}
