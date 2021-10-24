<?php

namespace Dominoes\Events;

final class EventManager
{
    /**
     * @var EventListenerInterface[]
     */
    private array $eventListeners = [];

    /**
     * @var EventInterface[]
     */
    private array $events = [];

    /**
     * @param EventListenerInterface $listener
     * @return void
     */
    public function subscribe(EventListenerInterface $listener): void
    {
        $this->unsubscribe($listener);
        $this->eventListeners[] = $listener;
    }

    /**
     * @param EventListenerInterface $listener
     * @return void
     */
    public function unsubscribe(EventListenerInterface $listener): void
    {
        $callback = function (EventListenerInterface $item) use ($listener): bool {
            return ($item !== $listener);
        };

        $this->eventListeners = array_filter($this->eventListeners, $callback);
    }

    /**
     * @param EventInterface $event
     */
    public function addEvent(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return void
     */
    public function fireEvents(): void
    {
        array_walk($this->events, fn (EventInterface $event) => $this->fireEvent($event));

        $this->events = [];
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    private function fireEvent(EventInterface $event): void
    {
        array_walk($this->eventListeners, function (EventListenerInterface $listener) use ($event): void {
            $listener->handleEvent($event);
        });
    }
}
