<?php

namespace Dominoes\Dices;

use Exception;

final class InvalidBindingException extends Exception
{
    /** @var string */
    private const ERROR_MESSAGE = 'Side values is not equal';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE);
    }
}
