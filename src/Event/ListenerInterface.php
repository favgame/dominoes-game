<?php

namespace FavGame\DominoesGame\Event;

interface ListenerInterface
{
    public function handleEvent(object $event): void;
}
