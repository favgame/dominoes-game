<?php

namespace FavGame\DominoesGame\GameField;

use LogicException;

final class InvalidAllocationException extends LogicException
{
    /** @var string */
    private const MESSAGE_ERROR = 'Invalid allocation';

    public function __construct()
    {
        parent::__construct(self::MESSAGE_ERROR);
    }
}
