<?php

namespace FavGame\DominoesGame\GameHandlers;

use DateTimeImmutable;
use FavGame\DominoesGame\Events\GameStepEvent;
use FavGame\DominoesGame\Events\PlayerChangeEvent;
use FavGame\DominoesGame\GameField\Field;
use FavGame\DominoesGame\GameField\InvalidAllocationException;
use FavGame\DominoesGame\GameField\InvalidStepException;
use FavGame\DominoesGame\Id;
use InfiniteIterator;

/**
 * Обработчик ходов игроков
 */
final class GameStepHandler extends AbstractGameHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     * @throws InvalidAllocationException
     * @throws InvalidStepException
     */
    public function handleData(): void
    {
        $gameField = new Field($this->gameData->getCellList(), $this->gameData->getDiceList());

        if (!$this->handlePlayerStep($gameField)) { // Игрок не сделал ход
            return;
        }

        if ($this->isPlayerWon() || !$gameField->hasSteps()) { // Игра окончена
            $this->handleNext();

            return;
        }

        $this->changeNextPlayer(); // Переход хода
    }

    /**
     * Обработать ход игрока
     *
     * @param Field $gameField
     * @return bool Возвращает TRUE, если игрок сделал ход, иначе FALSE
     * @throws InvalidAllocationException
     * @throws InvalidStepException
     */
    private function handlePlayerStep(Field $gameField): bool
    {
        $player = $this->gameData->getCurrentPlayer(); // Возможные ходы
        $stepList = $gameField->getAvailableSteps($player);

        if ($stepList->getItems()->count() == 0) { // Поход на базар
            $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);

            if (!$diceDistributor->distributeDice($player)) { // На базаре пусто
                return true; // Ход окончен
            }

            return false;
        }

        $step = $player->getStep($stepList); // Ожидание хода игрока

        if ($step) { // Игрок сделал ход
            $gameField->applyStep($step); // Положить игральную кость на поле
            $this->eventManager->addEvent(
                new GameStepEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $step)
            );

            return true; // Ход окончен
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
        $player = $this->gameData->getCurrentPlayer();
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
        $player = $this->gameData->getCurrentPlayer();

        if ($player) {
            while ($queue->current() !== $player) { // Перемотать очередь до текущего игрока
                $queue->next();
            }
        }

        $queue->next(); // Сменить очередь на следующего игрока
        $player = $queue->current();

        $this->gameData->setCurrentPlayer($player);
        $this->eventManager->addEvent(
            new PlayerChangeEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $player)
        );
    }
}
