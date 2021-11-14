<?php

namespace FavGame\DominoesGame\GameField;

use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceList;
use FavGame\DominoesGame\GameSteps\Step;
use FavGame\DominoesGame\GameSteps\StepList;
use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Игровое поле
 */
final class Field
{
    /**
     * @var CellList Список ячеек игрового поля
     */
    private CellList $cellList;

    /**
     * @var DiceList Список игральных костей
     */
    private DiceList $diceList;

    /**
     * @param CellList $cellList Список ячеек игрового поля
     * @param DiceList $diceList Список игральных костей
     */
    public function __construct(CellList $cellList, DiceList $diceList)
    {
        $this->cellList = $cellList;
        $this->diceList = $diceList;
    }

    /**
     * Применить ход игрока к игральному полю
     *
     * @param Step $step Ход игрока
     * @return void
     * @throws InvalidStepException Бросает исключение, если был передан недопустимый игровой ход
     * @throws InvalidAllocationException Бросает исключение, если невозможно установить кость в ячейку
     */
    public function applyStep(Step $step): void
    {
        $steps = $this->getAvailableSteps($step->getChosenDice()->getOwner());

        if (!$steps->hasStep($step)) {
            throw new InvalidStepException();
        }

        if ($step->hasDestinationCell()) {
            $step->getDestinationCell()->setRightDice($step->getChosenDice());
        } else {
            $this->cellList->addItem(new Cell(Id::next(), $step->getChosenDice(), $step->getChosenSide()));
        }

        $this->cellList->addItem(new Cell(Id::next(), $step->getChosenDice(), $step->getOtherSide()));
    }

    /**
     * Получить список доступных игровых ходов
     *
     * @param PlayerInterface $player Игрок, для которого будет расчитан список ходов
     * @return StepList Возвращает список доступных игровых ходов
     */
    public function getAvailableSteps(PlayerInterface $player): StepList
    {
        $steps = [];
        $freeCells = $this->cellList->getFreeCells();
        $playerDices = $this->diceList->getItemsByOwner($player);

        foreach ($playerDices as $dice) {
            if ($freeCells->count() < 1 && !$this->isUsedDice($dice)) {
                $steps[] = new Step($dice, null);

                continue;
            }

            foreach ($freeCells as $cell) {
                if ($cell->canSetRightDice($dice) && !$this->isUsedDice($dice)) {
                    $steps[] = new Step($dice, $cell);
                }
            }
        }

        return new StepList($steps);
    }

    /**
     * Проверить наличие игровых ходов
     *
     * @return bool Возвращает TRUE, если кто-то из игроков может сделать ход, иначе FALSE
     */
    public function hasSteps(): bool
    {
        foreach ($this->cellList->getFreeCells() as $cell) {
            foreach ($this->diceList->getItems() as $dice) {
                if ($cell->canSetRightDice($dice) && !$this->isUsedDice($dice)) {
                    return true;
                }
            }
        }

        return ($this->cellList->getFreeCells()->count() === 0); // Всегда TRUE, если это первый ход в раунде
    }

    /**
     * Проверить признак испозования игральной кости
     *
     * @param Dice $dice Игральная кость
     * @return bool Возвращает TRUE, если игральная кость находится на игровом поле, иначе FALSE
     */
    private function isUsedDice(Dice $dice): bool
    {
        $countCells = $this->cellList->getItemsByDice($dice)->count();

        return ($countCells > 0);
    }
}
