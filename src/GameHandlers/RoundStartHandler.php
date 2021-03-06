<?php

namespace FavGame\DominoesGame\GameHandlers;

use FavGame\DominoesGame\Events\GameStartEvent;
use FavGame\DominoesGame\Events\PlayerChangeEvent;
use FavGame\DominoesGame\Events\RoundStartEvent;

/**
 * Обработчик начала игрового раунда
 */
final class RoundStartHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        if ($this->gameData->getStatus()->isInitial()) { // Начало новой игры
            $this->gameData->getStatus()->setReady();
            $this->eventManager->addEvent(new GameStartEvent($this->gameData->getPlayerList()));
        }

        if ($this->gameData->getStatus()->isReady()) { // Начало нового раунда
            $this->gameData->getStatus()->setInProgress();
            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);
            $diceDistributor->distributeDices(); // Раздать игрокам игральные кости

            $this->eventManager->addEvent(new RoundStartEvent());

            // Выбрать игрока, который начнет игру
            $player = $this->gameData->getCurrentPlayer() ?: $this->gameData->getDiceList()->getStartItem()->getOwner();
            $this->gameData->setCurrentPlayer($player);
            $this->eventManager->addEvent(new PlayerChangeEvent($player));
        }

        $this->handleNext();
    }
}
