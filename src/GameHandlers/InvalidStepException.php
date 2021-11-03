<?php

namespace FavGame\DominoesGame\GameHandlers;

use LogicException;

final class InvalidStepException extends LogicException
{
    /** @var string */
    private const ERROR_MESSAGE = 'Invalid game step';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
