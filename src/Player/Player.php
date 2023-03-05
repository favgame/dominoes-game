<?php

namespace FavGame\DominoesGame\Player;

class Player
{
    public function __construct(
        private string $name,
    ) {
    }
    
    public function getName(): string
    {
        return $this->name;
    }
}
