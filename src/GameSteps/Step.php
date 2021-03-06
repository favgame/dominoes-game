<?php

namespace FavGame\DominoesGame\GameSteps;

use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceSide;
use FavGame\DominoesGame\GameField\Cell;

/**
 * Игровой ход
 */
final class Step
{
    /**
     * @var Dice|null Выбранная игральная кость
     */
    private Dice $chosenDice;

    /**
     * @var Cell|null Выбранная ячейка игрового поля
     */
    private ?Cell $destinationCell;

    /**
     * @param Dice $chosen Выбранная игральная кость
     * @param Cell|null $destinationCell Игральная кость, находящаяся на поле
     */
    public function __construct(Dice $chosen, ?Cell $destinationCell)
    {
        $this->chosenDice = $chosen;
        $this->destinationCell = $destinationCell;
    }

    /**
     * Получить выбранную игральную кость
     *
     * @return Dice
     */
    public function getChosenDice(): Dice
    {
        return $this->chosenDice;
    }

    /**
     * Получить подходящую сторону выбранной игральной кости
     *
     * @return DiceSide
     */
    public function getChosenSide(): DiceSide
    {
        if ($this->hasDestinationCell()) {
            if ($this->chosenDice->getSideB()->getValue() === $this->destinationCell->getValue()) {
                return $this->chosenDice->getSideB();
            }
        }

        return $this->chosenDice->getSideA();
    }

    /**
     * Получить вторую сторону выбранной игральной кости
     *
     * @return DiceSide
     */
    public function getOtherSide(): DiceSide
    {
        $sideA = $this->chosenDice->getSideA();
        $sideB = $this->chosenDice->getSideB();

        return $this->getChosenSide() === $sideA ? $sideB : $sideA;
    }

    /**
     * Получить ячейку игрового поля, в которой будет размещена игральная кость
     * Для первого хода в раунде всегда NULL
     *
     * @return Cell|null
     */
    public function getDestinationCell(): ?Cell
    {
        return $this->destinationCell;
    }

    /**
     * Признак наличия, указанной в ходе, ячейки игрового поля
     *
     * @return bool Возвращает TRUE, если в ходе указана ячейка игрового поля, иначе FALSE
     */
    public function hasDestinationCell(): bool
    {
        return ($this->destinationCell !== null);
    }
}
