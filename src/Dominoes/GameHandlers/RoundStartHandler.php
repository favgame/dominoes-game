<?php

namespace Dominoes\GameHandlers;

use DateTimeImmutable;
use Dominoes\Events\GameStartEvent;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\Events\RoundStartEvent;
use Dominoes\Id;

/**
 * Класс обработчика начала игрового раунда
 */
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

        if ($this->gameData->getState()->isInitial()) { // Начало новой игры
            $this->gameData->getState()->setReady();
            $this->eventManager->addEvent(
                new GameStartEvent(Id::next(), new DateTimeImmutable(), $this->gameData)
            );
        }

        if ($this->gameData->getState()->isReady()) { // Начало нового раунда
            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);
            $diceDistributor->distributeDices(); // Раздать игрокам игральные кости

            $this->eventManager->addEvent(
                new RoundStartEvent(Id::next(), new DateTimeImmutable(), $this->gameData)
            );

            // Выбрать игрока, который начнет игру
            $player = $this->gameData->getActivePlayer() ?: $this->gameData->getDiceList()->getStartItem()->getOwner();
            $this->gameData->setActivePlayer($player);
            $this->eventManager->addEvent(
                new PlayerChangeEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $player)
            );
        }

        $this->gameData->getState()->setInProgress();
        $this->handleNext();
    }
}
