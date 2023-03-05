<?php

namespace FavGame\DominoesGame\Event;

use RuntimeException;

interface EventDispatcherInterface
{
    public function subscribeListener(ListenerInterface $listener): void;
    
    public function unSubscribeListener(ListenerInterface $listener): void;
    
    /**
     * @throws RuntimeException
     */
    public function dispatchEvent(object $event): void;
}
