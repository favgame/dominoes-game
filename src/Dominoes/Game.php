<?php

namespace Dominoes;

use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\EventManager;
use Dominoes\GameHandlers\GameStepHandler;
use Dominoes\GameHandlers\HandlerInterface;
use Dominoes\GameHandlers\InvalidStepException;
use Dominoes\GameHandlers\RoundEndHandler;
use Dominoes\GameHandlers\RoundStartHandler;

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
    }

    /**
     * @return bool
     * @throws GameRulesException
     * @throws InvalidBindingException
     * @throws InvalidStepException
     */
    public function run(): bool
    {
        $this->checkRules();
        $this->eventManager->fireEvents();

        if ($this->gameData->getState()->isDone()) {
            return false;
        }

        $this->mainHandler->handleData();

        return true;
    }

    /**
     * @return EventManager
     */
    public function getEventManager(): EventManager
    {
        return $this->eventManager;
    }

    /**
     * @throws GameRulesException
     * @return void
     */
    private function checkRules(): void
    {
        $rules = $this->gameData->getRules();
        $playerCount = $this->gameData->getPlayerList()->getItems()->count();

        if ($playerCount < $rules->getMinPlayerCount() || $playerCount > $rules->getMaxPlayerCount()) {
            throw new GameRulesException();
        }
    }
}
