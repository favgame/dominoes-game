<?php

namespace FavGame\DominoesGame\Events;

use DateTimeInterface;
use FavGame\DominoesGame\Id;

/**
 * Событие начала раунда
 */
final class RoundStartEvent extends AbstractGameEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Round start';

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     */
    public function __construct(Id $id, DateTimeInterface $createdAt)
    {
        parent::__construct($id, $createdAt, self::EVENT_NAME);
    }
}
