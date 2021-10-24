<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\GameStartEvent;
use Dominoes\Events\RoundStartEvent;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

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

            $playerQueue = new PlayerQueue($this->eventManager, $this->gameData);
            $playerQueue->changePlayer($this->getActivePlayer());

            $this->gameData->getState()->setInProgress();
        }

        $this->handleNext();
    }

    /**
     * @return PlayerInterface
     */
    private function getActivePlayer(): PlayerInterface
    {
        $activePlayer = null;
        $maxPointAmount = 0;

        foreach ($this->gameData->getDiceList()->getItems() as $item) {
            if ($item->hasOwner() && $item->getPointAmount() >= $maxPointAmount) {
                $maxPointAmount = $item->getPointAmount();
                $activePlayer = $item->getOwner();
            }
        }

        return $activePlayer;
    }
}
