<?php

namespace FavGame\DominoesGame\Events;

use DateTimeInterface;
use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerList;

/**
 * Событие начала новой игры
 */
final class GameStartEvent extends AbstractGameEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Game start';

    /**
     * @var PlayerList Список игроков
     */
    private PlayerList $playerList;

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param PlayerList $playerList Список игроков
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, PlayerList $playerList)
    {
        $this->playerList = $playerList;

        parent::__construct($id, $createdAt, self::EVENT_NAME);
    }

    /**
     * Получить список игроков
     *
     * @return PlayerList
     */
    public function getPlayerList(): PlayerList
    {
        return $this->playerList;
    }
}
