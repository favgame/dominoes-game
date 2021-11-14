<?php

namespace FavGame\DominoesGame\GameHandlers;

use LogicException;

/**
 * Логическое исключения неверного количества необходимых для игры игроков
 */
final class PlayerCountException extends LogicException
{
    /** @var string */
    private const ERROR_MESSAGE = 'Invalid number of players';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
