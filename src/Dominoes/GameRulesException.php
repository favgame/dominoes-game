<?php

namespace Dominoes;

use LogicException;

final class GameRulesException extends LogicException
{
    /** @var string */
    private const ERROR_MESSAGE = 'Invalid number of players';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
