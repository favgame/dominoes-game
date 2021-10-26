<?php

namespace Dominoes\GameLogger;

use Dominoes\Events\EventInterface;

interface MessageFactoryInterface
{
    /**
     * @param EventInterface $event
     * @return string
     */
    public function createMessage(EventInterface $event): string;
}
