<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\EventManager;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\GameData;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;
use InfiniteIterator;

final class PlayerQueue
{
    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @var GameData
     */
    private GameData $gameData;

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
     * @param PlayerInterface $player
     * @return void
     */
    public function changePlayer(PlayerInterface $player): void
    {
        $this->gameData->setActivePlayer($player);
        $this->eventManager->addEvent(new PlayerChangeEvent(Id::next(), $this->gameData, $player));
    }

    /**
     * @return void
     */
    public function changeNextPlayer(): void
    {
        $this->changePlayer($this->createIterator()->current());
    }

    /**
     * @return InfiniteIterator
     */
    private function createIterator(): InfiniteIterator
    {
        $iterator = new InfiniteIterator($this->gameData->getPlayerList()->getItems()->getIterator());
        $player = $this->gameData->getActivePlayer();

        if ($player) {
            while ($iterator->current() !== $player) {
                $iterator->next();
            }
        }

        return $iterator;
    }
}
