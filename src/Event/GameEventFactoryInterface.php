<?php

namespace FavGame\DominoesGame\Event;

interface GameEventFactoryInterface
{
    public function createEvent(GameEventType $type, mixed ...$params): GameEvent;
}
