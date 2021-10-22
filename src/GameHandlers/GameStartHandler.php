<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\GameStartEvent;
use Dominoes\GameData;
use Dominoes\Id;

final class GameStartHandler extends AbstractGameHandler
{
    /**
     * @param GameData $gameData
     * @return void
     */
    public function handleData(GameData $gameData): void
    {
        if ($gameData->getState()->isInitial()) {
            $this->eventManager->addEvent(new GameStartEvent(Id::next(), $gameData));
        }

        if (!$gameData->getState()->isDone()) {
            $this->handleNext($gameData);
        }
    }
}
