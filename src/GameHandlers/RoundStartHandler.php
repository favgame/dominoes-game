<?php

namespace FavGame\DominoesGame\GameHandlers;

use DateTimeImmutable;
use FavGame\DominoesGame\Events\GameStartEvent;
use FavGame\DominoesGame\Events\PlayerChangeEvent;
use FavGame\DominoesGame\Events\RoundStartEvent;
use FavGame\DominoesGame\Id;

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
        if ($this->gameData->getStatus()->isDone()) {
            return;
        }

        if ($this->gameData->getStatus()->isInitial()) { // Начало новой игры
            $this->gameData->getStatus()->setReady();
            $this->eventManager->addEvent(
                new GameStartEvent(Id::next(), new DateTimeImmutable(), $this->gameData)
            );
        }

        if ($this->gameData->getStatus()->isReady()) { // Начало нового раунда
            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);
            $diceDistributor->distributeDices(); // Раздать игрокам игральные кости

            $this->eventManager->addEvent(
                new RoundStartEvent(Id::next(), new DateTimeImmutable(), $this->gameData)
            );

            // Выбрать игрока, который начнет игру
            $player = $this->gameData->getCurrentPlayer() ?: $this->gameData->getDiceList()->getStartItem()->getOwner();
            $this->gameData->setCurrentPlayer($player);
            $this->eventManager->addEvent(
                new PlayerChangeEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $player)
            );
        }

        $this->gameData->getStatus()->setInProgress();
        $this->handleNext();
    }
}
