<?php

namespace FavGame\DominoesGame\GameSteps;

use FavGame\DominoesGame\Dices\Dice;

/**
 * Игровой шаг
 */
final class Step
{
    /**
     * @var Dice|null Выбранная игральная кость
     */
    private Dice $chosenDice;

    /**
     * @var Dice Игральная кость, находящаяся на поле
     */
    private Dice $destinationDice;

    /**
     * @param Dice $chosenDice Выбранная игральная кость
     * @param Dice $destinationDice Игральная кость, находящаяся на поле
     */
    public function __construct(Dice $chosenDice, Dice $destinationDice)
    {
        $this->chosenDice = $chosenDice;
        $this->destinationDice = $destinationDice;
    }

    /**
     * Получить выбранную игральную кость
     * @return Dice
     */
    public function getChosenDice(): Dice
    {
        return $this->chosenDice;
    }

    /**
     * Получить игральную кость, находящуюся на поле
     *
     * @return Dice
     */
    public function getDestinationDice(): Dice
    {
        return $this->destinationDice;
    }
}
