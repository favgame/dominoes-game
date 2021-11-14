<?php

namespace FavGame\DominoesGame\Events;

/**
 * Событие начала раунда
 */
final class RoundStartEvent extends AbstractEvent
{
    /** @var string Название события */
    private const EVENT_NAME = 'Round start';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct(self::EVENT_NAME);
    }
}
