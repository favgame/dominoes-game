<?php

namespace FavGame\DominoesGame\Round;

enum RoundState: int
{
    case initial = 0;
    case inProgress = 1;
    case complete = 2;
    
    public function isInitial(): bool
    {
        return ($this === self::initial);
    }
    
    public function isInProgress(): bool
    {
        return ($this === self::inProgress);
    }
    
    public function isComplete(): bool
    {
        return ($this === self::complete);
    }
}
