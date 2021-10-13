<?php

namespace Dominoes\Events;

interface EventListenerInterface
{
    /**
     * @param EventInterface $event
     * @return void
     */
    public function handleEvent(EventInterface $event): void;
}
