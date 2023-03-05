<?php

namespace FavGame\DominoesGame\Field;

use LogicException;

class InvalidAllocationException extends LogicException
{
    public function __construct(string $message = "Invalid Allocation")
    {
        parent::__construct($message);
    }
}
