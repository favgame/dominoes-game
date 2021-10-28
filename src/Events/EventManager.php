<?php

namespace FavGame\Dominoes\Events;

/**
 * Менеджер событий
 */
final class EventManager
{
    /**
     * @var EventListenerInterface[] Список наблюдателей
     */
    private array $eventListeners = [];

    /**
     * @var EventInterface[] Буффер событий
     */
    private array $events = [];

    /**
     * Подписать наблюдателя на получение событий
     *
     * @param EventListenerInterface $listener Наблюдатель
     * @return void
     */
    public function subscribe(EventListenerInterface $listener): void
    {
        $this->unsubscribe($listener);
        $this->eventListeners[] = $listener;
    }

    /**
     * Отписать наблюдателя от получения событий
     *
     * @param EventListenerInterface $listener Наблюдатель
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
     * Добавить событие в буффер
     *
     * @param EventInterface $event Событие
     * @return void
     */
    public function addEvent(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * Отправить все события из буффера наблюдателям
     *
     * @return void
     */
    public function fireEvents(): void
    {
        array_walk($this->events, fn (EventInterface $event) => $this->fireEvent($event));

        $this->events = [];
    }

    /**
     * Отправить событие наблюдателям
     *
     * @param EventInterface $event Событие
     * @return void
     */
    private function fireEvent(EventInterface $event): void
    {
        array_walk($this->eventListeners, function (EventListenerInterface $listener) use ($event): void {
            $listener->handleEvent($event);
        });
    }
}
