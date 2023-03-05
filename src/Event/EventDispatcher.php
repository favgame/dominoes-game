<?php

namespace FavGame\DominoesGame\Event;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var ListenerInterface[]
     */
    private array $listeners = [];
    
    public function subscribeListener(ListenerInterface $listener): void
    {
        $this->listeners[spl_object_id($listener)] = $listener;
    }
    
    public function unSubscribeListener(ListenerInterface $listener): void
    {
        unset($this->listeners[spl_object_id($listener)]);
    }
    
    public function dispatchEvent(object $event): void
    {
        foreach ($this->listeners as $listener) {
            $listener->handleEvent($event);
        }
    }
}
