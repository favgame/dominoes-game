<?php

namespace FavGame\Dominoes\GameHandlers;

/**
 * Интерфейс обработчика из цепочки обязанностей
 */
interface HandlerInterface
{
    /**
     * Запустить обработчик
     *
     * @return void
     */
    public function handleData(): void;

    /**
     * Установить следующий обработчик в цепочку обязанностей
     *
     * @param HandlerInterface $handler Следующий обработчик
     * @return void
     */
    public function setNextHandler(self $handler): void;
}
