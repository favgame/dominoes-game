<?php

namespace FavGame\DominoesGame\GameField;

use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceList;
use FavGame\DominoesGame\GameSteps\Step;
use FavGame\DominoesGame\GameSteps\StepList;
use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerInterface;

final class Field
{
    /**
     * @var CellList
     */
    private CellList $cellList;

    /**
     * @var DiceList
     */
    private DiceList $diceList;

    /**
     * @param CellList $cellList
     * @param DiceList $diceList
     * @return void
     */
    public function __construct(CellList $cellList, DiceList $diceList)
    {
        $this->cellList = $cellList;
        $this->diceList = $diceList;
    }

    /**
     * @param Step $step
     * @return void
     * @throws InvalidAllocationException
     * @throws InvalidStepException
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
     * @param PlayerInterface $player
     * @return StepList
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
     * @return bool
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

        return ($this->cellList->getFreeCells()->count() === 0);
    }

    /**
     * @param Dice $dice
     * @return bool
     */
    private function isUsedDice(Dice $dice): bool
    {
        $countCells = $this->cellList->getItemsByDice($dice)->count();

        return ($countCells > 0);
    }
}
