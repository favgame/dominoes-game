<?php

namespace Dominoes\GameHandlers;

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
        if ($this->gameData->getState()->isInitial()) {
            $this->gameData->getState()->setValueInProgress();

            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);
            $diceDistributor->distributeDices();

            $this->eventManager->addEvent(new RoundStartEvent(Id::next(), $this->gameData));

            $playerQueue = new PlayerQueue($this->eventManager, $this->gameData);
            $playerQueue->changePlayer($this->getActivePlayer());
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
