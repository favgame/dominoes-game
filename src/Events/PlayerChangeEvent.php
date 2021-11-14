<?php

namespace FavGame\DominoesGame\Events;

use DateTimeInterface;
use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Событие смены игрока
 */
final class PlayerChangeEvent extends AbstractGameEvent
{
    /** @var string Название события */
    public const EVENT_NAME = 'Player change';

    /**
     * @var PlayerInterface Выбранный игрок
     */
    private PlayerInterface $player;

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param PlayerInterface $player Выбранный игрок
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, PlayerInterface $player)
    {
        $this->player = $player;

        parent::__construct($id, $createdAt, self::EVENT_NAME);
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
