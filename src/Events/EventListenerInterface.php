<?php

namespace FavGame\DominoesGame\Events;

/**
 * Интерфейс наблюдателя событий
 */
interface EventListenerInterface
{
    /**
     * @param EventInterface $event
     * @return void
     */
    public function handleEvent(EventInterface $event): void;
}
