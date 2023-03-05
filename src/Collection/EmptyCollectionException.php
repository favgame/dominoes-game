<?php

namespace FavGame\DominoesGame\Collection;

use UnderflowException;

class EmptyCollectionException extends UnderflowException
{
    public function __construct(string $message = 'Collection is empty')
    {
        parent::__construct($message);
    }
}
