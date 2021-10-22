<?php

namespace Dominoes\GameHandlers;

use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\Events\GameStepEvent;
use Dominoes\GameData;
use Dominoes\GameSteps\StepListFactory;
use Dominoes\Id;

final class GameStepHandler extends AbstractGameHandler implements HandlerInterface
{
    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @param EventManager $eventManager
     */
    public function __construct(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @param GameData $gameData
     * @return void
     */
    public function handleData(GameData $gameData): void
    {
        $player = $gameData->getActivePlayer(); // Текущий игрок
        $stepList = (new StepListFactory($gameData->getDiceList()))->createList($player); // Возможные ходы
        $step = $player->getStep($stepList); // Ожидание хода игрока

        if ($step) { // Игрок сделал ход
            $step->getChosenDice()->setBinding($step->getDestinationDice());
            $this->eventManager->addEvent(new GameStepEvent(Id::next(), $gameData, $step));

            if ($this->nextHandler) {
                $this->nextHandler->handleData($gameData);
            }
        }
    }
}
