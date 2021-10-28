<?php

namespace FavGame\Dominoes\GameHandlers;

use DateTimeImmutable;
use FavGame\Dominoes\Dices\InvalidBindingException;
use FavGame\Dominoes\Events\GameStepEvent;
use FavGame\Dominoes\Events\PlayerChangeEvent;
use FavGame\Dominoes\GameSteps\StepList;
use FavGame\Dominoes\Id;
use InfiniteIterator;

/**
 * Обработчик ходов игроков
 */
final class GameStepHandler extends AbstractGameHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     * @throws InvalidStepException
     * @throws InvalidBindingException
     */
    public function handleData(): void
    {
        if (!$this->handlePlayerStep()) { // Игрок не сделал ход
            return;
        }

        if ($this->isPlayerWon() || !$this->hasGameSteps()) { // Игра закончена
            $this->handleNext();

            return;
        }

        $this->changeNextPlayer(); // Переход хода
    }

    /**
     * Обработать ход игрока
     *
     * @return bool Возвращает TRUE, если игрок сделал ход, иначе FALSE
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
            if (!$stepList->hasItem($step)) { // Попытка сделать недопустимый игровой ход
                throw new InvalidStepException();
            }

            $step->getChosenDice()->setBinding($step->getDestinationDice()); // Положить игральную кость на поле

            $this->eventManager->addEvent(
                new GameStepEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $step)
            );

            return true; // Ход окончен
        }

        return false;
    }

    /**
     * Определить наличие возможных игровых ходов
     *
     * @return bool Возвращает TRUE, если есть возможные ходы, иначе FALSE
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
     * Определить, является ли текущий игрок победителем
     *
     * @return bool Возвращает TRUE, если у игрока не осталось игральных костей, иначе FALSE
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
     * Сменить игрока для следующего хода
     *
     * @return void
     */
    private function changeNextPlayer(): void
    {
        $queue = new InfiniteIterator($this->gameData->getPlayerList()->getItems()->getIterator());
        $player = $this->gameData->getActivePlayer();

        if ($player) {
            while ($queue->current() !== $player) { // Перемотать очередь до текущего игрока
                $queue->next();
            }
        }

        $queue->next(); // Сменить очередь на следующего игрока
        $player = $queue->current();

        $this->gameData->setActivePlayer($player);

        $this->eventManager->addEvent(
            new PlayerChangeEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $player)
        );
    }
}
