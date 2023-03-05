<?php

namespace FavGame\DominoesGame\Field;

use LogicException;

class InvalidStepException extends LogicException
{
    public function __construct(string $message = 'Invalid step')
    {
        parent::__construct($message);
    }
}
