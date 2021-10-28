<?php

namespace FavGame\Dominoes\GameLogger;

use FavGame\Dominoes\Events\EventInterface;

/**
 * Интерфейс фабрики сообщений
 */
interface MessageFactoryInterface
{
    /**
     * Создать запись для лога
     *
     * @param EventInterface $event Событие
     * @return string
     */
    public function createMessage(EventInterface $event): string;
}
