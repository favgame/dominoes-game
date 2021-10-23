<?php

namespace Dominoes\GameHandlers;

use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\GameStepEvent;
use Dominoes\GameSteps\StepListFactory;
use Dominoes\Id;

final class GameStepHandler extends AbstractGameHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     * @throws InvalidBindingException
     */
    public function handleData(): void
    {
        if (!$this->handlePlayerStep()) {
            return;
        }

        if ($this->isPlayerWon() || !$this->hasGameSteps()) { // Игра закончена
            $this->handleNext();

            return;
        }

        $playerQueue = new PlayerQueue($this->eventManager, $this->gameData);
        $playerQueue->changeNextPlayer();
    }

    /**
     * @return bool
     * @throws InvalidBindingException
     */
    private function handlePlayerStep(): bool
    {
        $player = $this->gameData->getActivePlayer();
        $stepList = (new StepListFactory($this->gameData->getDiceList()))->createList($player); // Возможные ходы

        if ($stepList->getItems()->count() == 0) { // Поход на базар
            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);

            if (!$diceDistributor->distributeDice($player)) { // На базаре пусто
                return true; // Ход окончен
            }

            return false;
        }

        $step = $player->getStep($stepList); // Ожидание хода игрока

        if ($step) { // Игрок сделал ход
            $step->getChosenDice()->setBinding($step->getDestinationDice());
            $this->eventManager->addEvent(new GameStepEvent(Id::next(), $this->gameData, $step));

            return true; // Ход окончен
        }

        return false;
    }

    /**
     * @return bool
     */
    private function hasGameSteps(): bool
    {
        if ($this->gameData->getDiceList()->getFreeItem() !== null) { // На базаре есть кости
            return true;
        }

        $stepListFactory = new StepListFactory($this->gameData->getDiceList());

        foreach ($this->gameData->getPlayerList()->getItems() as $player) {
            if ($stepListFactory->createList($player)->getItems()->count() > 0) { // У игрока есть ход
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isPlayerWon(): bool
    {
        $player = $this->gameData->getActivePlayer();
        $diceCount = $this->gameData->getDiceList()->getItemsByOwner($player)->count(); // Кол-во костей на руках

        if ($diceCount == 0) { // У игрока закончились кости
            return true;
        }

        return false;
    }
}
