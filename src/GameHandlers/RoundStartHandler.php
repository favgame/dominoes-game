<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\GameStartEvent;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\Events\RoundStartEvent;
use Dominoes\Id;

final class RoundStartHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        if ($this->gameData->getState()->isDone()) {
            return;
        }

        if ($this->gameData->getState()->isInitial()) {
            $this->gameData->getState()->setReady();
            $this->eventManager->addEvent(new GameStartEvent(Id::next(), $this->gameData));
        }

        if ($this->gameData->getState()->isReady()) {
            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);
            $diceDistributor->distributeDices();

            $this->eventManager->addEvent(new RoundStartEvent(Id::next(), $this->gameData));

            $player = $this->gameData->getActivePlayer() ?: $this->gameData->getDiceList()->getStartItem()->getOwner();
            $this->gameData->setActivePlayer($player);
            $this->eventManager->addEvent(new PlayerChangeEvent(Id::next(), $this->gameData, $player));
        }

        $this->gameData->getState()->setInProgress();
        $this->handleNext();
    }
}
