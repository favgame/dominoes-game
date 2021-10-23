<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\EventManager;
use Dominoes\GameData;

abstract class AbstractGameHandler implements HandlerInterface
{
    /**
     * @var HandlerInterface|null
     */
    protected ?HandlerInterface $nextHandler = null;

    /**
     * @var EventManager
     */
    protected EventManager $eventManager;

    /**
     * @var GameData
     */
    protected GameData $gameData;

    /**
     * @param EventManager $eventManager
     * @param GameData $gameData
     */
    public function __construct(EventManager $eventManager, GameData $gameData)
    {
        $this->eventManager = $eventManager;
        $this->gameData = $gameData;
    }

    /**
     * @param HandlerInterface $handler
     * @return void
     */
    public function setNextHandler(HandlerInterface $handler): void
    {
        $this->nextHandler = $handler;
    }

    /**
     * @return void
     */
    protected function handleNext(): void
    {
        if ($this->nextHandler) {
            $this->nextHandler->handleData();
        }
    }
}
