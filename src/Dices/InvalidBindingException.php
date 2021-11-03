<?php

namespace FavGame\DominoesGame\Dices;

use LogicException;

final class InvalidBindingException extends LogicException
{
    /** @var string */
    private const ERROR_MESSAGE = 'Invalid binding';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
