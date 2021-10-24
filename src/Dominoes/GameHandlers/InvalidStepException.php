<?php

namespace Dominoes\GameHandlers;

use Exception;

final class InvalidStepException extends Exception
{
    /** @var string */
    private const ERROR_MESSAGE = 'Invalid game step';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
