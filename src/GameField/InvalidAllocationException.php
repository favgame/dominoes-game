<?php

namespace FavGame\DominoesGame\GameField;

use LogicException;

/**
 * Логическое исключение неверного расположения игральной кости в ячейке игрового поля
 */
final class InvalidAllocationException extends LogicException
{
    /** @var string Текст ошибки */
    private const MESSAGE_ERROR = 'Invalid allocation';

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct(self::MESSAGE_ERROR);
    }
}
