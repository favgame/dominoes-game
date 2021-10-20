<?php

namespace Dominoes\GameSteps;

use Dominoes\Dices\DiceList;
use Dominoes\Players\PlayerInterface;

final class StepListFactory
{
    /**
     * @var DiceList
     */
    private DiceList $diceList;

    /**
     * @param DiceList $diceList
     */
    public function __construct(DiceList $diceList)
    {
        $this->diceList = $diceList;
    }

    /**
     * @param PlayerInterface $player
     * @return StepList
     */
    public function createList(PlayerInterface $player): StepList
    {
        $activeDices = $this->diceList->getActiveItems();
        $playerDices = $this->diceList->getItemsByOwner($player);
        $items = [];

        foreach ($playerDices as $playerDice) {
            foreach ($activeDices as $activeDice) {
                if ($playerDice->canBinding($activeDice)) {
                    $items[] = new Step($playerDice, $activeDice);
                }
            }
        }

        return new StepList($items);
    }
}
