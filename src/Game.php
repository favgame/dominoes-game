<?php

namespace Dominoes;

use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\GameHandlers\GameStepHandler;
use Dominoes\GameHandlers\HandlerInterface;
use Dominoes\GameHandlers\RoundEndHandler;
use Dominoes\GameHandlers\RoundStartHandler;
use Dominoes\Players\PlayerInterface;

final class Game
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
     * @var HandlerInterface
     */
    private HandlerInterface $mainHandler;

    /**
     * @param GameData $gameData
     */
    public function __construct(GameData $gameData)
    {
        $this->gameData = $gameData;
        $this->eventManager = new EventManager();

        $roundStartHandler = new RoundStartHandler($this->eventManager, $gameData);
        $stepHandler = new GameStepHandler($this->eventManager, $gameData);
        $roundEndHandler = new RoundEndHandler($this->eventManager, $gameData);

        $roundStartHandler->setNextHandler($stepHandler);
        $stepHandler->setNextHandler($roundEndHandler);
        $roundEndHandler->setNextHandler($roundStartHandler);

        $this->mainHandler = $roundStartHandler;
        $this->subscribePlayers();
    }

    /**
     * @return bool
     */
    public function run(): bool
    {
        $this->eventManager->fireEvents();

        if ($this->gameData->getState()->isDone()) {
            return false;
        }

        $this->mainHandler->handleData();

        return true;
    }

    /**
     * @return void
     */
    private function subscribePlayers(): void
    {
        $players = $this->gameData->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            $this->eventManager->subscribe($player, DiceGivenEvent::EVENT_NAME);
        });
    }
}
