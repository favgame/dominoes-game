<?php

namespace Dominoes\Events;

final class EventSubscription
{
    /**
     * @var EventListenerInterface
     */
    private EventListenerInterface $eventListener;

    /**
     * @var string
     */
    private string $eventName;

    /**
     * @param EventListenerInterface $eventListener
     * @param string $eventName
     */
    public function __construct(EventListenerInterface $listener, string $eventName)
    {
        $this->eventListener = $eventListener;
        $this->eventName = $eventName;
    }

    /**
     * @return EventListenerInterface
     */
    public function getEventListener(): EventListenerInterface
    {
        return $this->eventListener;
    }

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }
}
