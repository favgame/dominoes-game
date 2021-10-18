<?php

namespace Dominoes\Dices;

final class DiceStep
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
     * @return Dice|null
     */
    public function getChosenDice(): ?Dice
    {
        return $this->chosenDice;
    }

    /**
     * @return Dice|null
     */
    public function getDestinationDice(): ?Dice
    {
        return $this->destinationDice;
    }
}
