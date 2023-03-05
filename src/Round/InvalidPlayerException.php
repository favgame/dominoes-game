<?php

namespace FavGame\DominoesGame\Round;

use LogicException;

class InvalidPlayerException extends LogicException
{
    public function __construct(string $message = 'Invalid player queue')
    {
        parent::__construct($message);
    }
}
