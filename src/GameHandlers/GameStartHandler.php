<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\GameStartEvent;
use Dominoes\Id;

final class GameStartHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        if ($this->gameData->getState()->isInitial()) {
            $this->eventManager->addEvent(new GameStartEvent(Id::next(), $this->gameData));
        }

        if (!$this->gameData->getState()->isDone()) {
            $this->handleNext();
        }
    }
}
