<?php

namespace Dominoes\Events;

final class EventManager
{
    /**
     * @var EventSubscription[]
     */
    private array $eventSubscriptions = [];

    /**
     * @var EventInterface[]
     */
    private array $events = [];

    /**
     * @param EventListenerInterface $listener
     * @param string $eventName
     * @return void
     */
    public function subscribe(EventListenerInterface $listener, string $eventName): void
    {
        $this->unsubscribe($listener, $eventName);
        $this->eventSubscriptions[] = new EventSubscription($listener, $eventName);
    }

    /**
     * @param EventListenerInterface $listener
     * @param string $eventName
     * @return void
     */
    public function unsubscribe(EventListenerInterface $listener, string $eventName): void
    {
        $callback = function (EventSubscription $subscription) use ($eventName, $listener) {
            return ($subscription->getEventListener() !== $listener && $subscription->getEventName() != $eventName);
        };

        $this->eventSubscriptions = array_filter($this->eventSubscriptions, $callback);
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
     */
    private function fireEvent(EventInterface $event): void
    {
        array_walk($this->eventSubscriptions, function (EventSubscription $subscription) use ($event) {
            if ($subscription->getEventName() == $event->getName()) {
                $subscription->getEventListener()->handleEvent($event);
            }
        });
    }
}
