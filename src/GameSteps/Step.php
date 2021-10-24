<?php

namespace Dominoes\GameSteps;

use Dominoes\Dices\Dice;

final class Step
{
    /**
     * @var Dice|null
     */
    private Dice $chosenDice;

    /**
     * @var Dice|null
     */
    private Dice $destinationDice;

    /**
     * @param Dice $chosenDice
     * @param Dice $destinationDice
     */
    public function __construct(Dice $chosenDice, Dice $destinationDice)
    {
        $this->chosenDice = $chosenDice;
        $this->destinationDice = $destinationDice;
    }

    /**
     * @return Dice
     */
    public function getChosenDice(): Dice
    {
        return $this->chosenDice;
    }

    /**
     * @return Dice
     */
    public function getDestinationDice(): ?Dice
    {
        return $this->destinationDice;
    }
}
