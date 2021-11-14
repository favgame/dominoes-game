<?php

namespace FavGame\DominoesGame\Events;

use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Событие смены игрока
 */
final class PlayerChangeEvent extends AbstractEvent
{
    /** @var string Название события */
    public const EVENT_NAME = 'Player change';

    /**
     * @var PlayerInterface Выбранный игрок
     */
    private PlayerInterface $player;

    /**
     * @param PlayerInterface $player Выбранный игрок
     */
    public function __construct(PlayerInterface $player)
    {
        $this->player = $player;

        parent::__construct(self::EVENT_NAME);
    }

    /**
     * Получить выбранного игрока
     *
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }
}
