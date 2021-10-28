<?php

namespace FavGame\Dominoes\GameLogger;

use FavGame\Dominoes\Events\EventInterface;

interface MessageFactoryInterface
{
    /**
     * @param EventInterface $event
     * @return string
     */
    public function createMessage(EventInterface $event): string;
}
