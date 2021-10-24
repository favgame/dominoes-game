<?php

namespace Dominoes\GameHandlers;

use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\GameStepEvent;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\GameSteps\Step;
use Dominoes\GameSteps\StepList;
use Dominoes\Id;
use InfiniteIterator;

final class GameStepHandler extends AbstractGameHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     * @throws InvalidStepException
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

        $this->changeNextPlayer();
    }

    /**
     * @return bool
     * @throws InvalidStepException
     * @throws InvalidBindingException
     */
    private function handlePlayerStep(): bool
    {
        $player = $this->gameData->getActivePlayer();
        $stepList = new StepList($this->gameData->getDiceList(), $player); // Возможные ходы

        if ($stepList->getItems()->count() == 0) { // Поход на базар
            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);

            if (!$diceDistributor->distributeDice($player)) { // На базаре пусто
                return true; // Ход окончен
            }

            return false;
        }

        $step = $player->getStep($stepList); // Ожидание хода игрока

        if ($step) { // Игрок сделал ход
            if (!$stepList->hasItem($step)) {
                throw new InvalidStepException();
            }

            $this->logStep($step);

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

        foreach ($this->gameData->getPlayerList()->getItems() as $player) {
            $stepList = (new StepList($this->gameData->getDiceList(), $player));

            if ($stepList->getItems()->count() > 0) { // У игрока есть ход
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

    /**
     * @return void
     */
    private function changeNextPlayer(): void
    {
        $iterator = new InfiniteIterator($this->gameData->getPlayerList()->getItems()->getIterator());
        $player = $this->gameData->getActivePlayer();

        if ($player) {
            while ($iterator->current() !== $player) {
                $iterator->next();
            }
        }

        $iterator->next();
        $player = $iterator->current();

        $this->gameData->setActivePlayer($player);
        $this->eventManager->addEvent(new PlayerChangeEvent(Id::next(), $this->gameData, $player));
    }

    /**
     * @param Step $step
     * @return void
     */
    private function logStep(Step $step): void
    {
        echo sprintf(
            "%s: [%d|%d] -> [%d|%d]\n",
            $step->getChosenDice()->getOwner()->getName(),
            $step->getChosenDice()->getSideA()->getValue(),
            $step->getChosenDice()->getSideB()->getValue(),
            $step->getDestinationDice()->getSideA()->getValue(),
            $step->getDestinationDice()->getSideB()->getValue()
        );
    }
}
