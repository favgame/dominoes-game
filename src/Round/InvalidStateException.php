<?php

namespace FavGame\DominoesGame\Round;

use LogicException;

class InvalidStateException extends LogicException
{
    public function __construct(string $message = 'Invalid round state')
    {
        parent::__construct($message);
    }
}
