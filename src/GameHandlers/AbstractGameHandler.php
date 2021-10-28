<?php

namespace FavGame\Dominoes\GameHandlers;

use FavGame\Dominoes\Events\EventManager;
use FavGame\Dominoes\GameData;

/**
 * Абстрактный обработчик в цепочке обязанностей
 */
abstract class AbstractGameHandler implements HandlerInterface
{
    /**
     * @var HandlerInterface|null
     */
    protected ?HandlerInterface $nextHandler = null;

    /**
     * @var EventManager Менеджер событий
     */
    protected EventManager $eventManager;

    /**
     * @var GameData Игровые данные
     */
    protected GameData $gameData;

    /**
     * @param EventManager $eventManager Менеджер событий
     * @param GameData $gameData Игровые данные
     */
    public function __construct(EventManager $eventManager, GameData $gameData)
    {
        $this->eventManager = $eventManager;
        $this->gameData = $gameData;
    }

    /**
     * @inheritDoc
     */
    public function setNextHandler(HandlerInterface $handler): void
    {
        $this->nextHandler = $handler;
    }

    /**
     * Выполнить следующий обработчик в цепочке обязанностей
     *
     * @return void
     */
    protected function handleNext(): void
    {
        if ($this->nextHandler) {
            $this->nextHandler->handleData();
        }
    }
}
