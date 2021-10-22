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
     * @param EventManager $eventManager
     */
    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
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
     * @param GameData $gameData
     * @return void
     */
    protected function handleNext(GameData $gameData): void
    {
        if ($this->nextHandler) {
            $this->nextHandler->handleData($gameData);
        }
    }
}
