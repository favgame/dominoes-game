<?php

namespace FavGame\DominoesGame\Events;

use FavGame\DominoesGame\Players\PlayerList;

/**
 * Событие начала новой игры
 */
final class GameStartEvent extends AbstractEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Game start';

    /**
     * @var PlayerList Список игроков
     */
    private PlayerList $playerList;

    /**
     * @param PlayerList $playerList Список игроков
     */
    public function __construct(PlayerList $playerList)
    {
        $this->playerList = $playerList;

        parent::__construct(self::EVENT_NAME);
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
