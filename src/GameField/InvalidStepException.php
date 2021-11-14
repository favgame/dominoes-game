<?php

namespace FavGame\DominoesGame\GameField;

use LogicException;

/**
 * Логическое исключение недопустимого игрового хода
 */
final class InvalidStepException extends LogicException
{
    /** @var string Текст ошибки */
    private const ERROR_MESSAGE = 'Invalid game step';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
