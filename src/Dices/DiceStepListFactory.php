<?php

namespace Dominoes\Dices;

use Dominoes\Players\PlayerInterface;

final class DiceStepListFactory
{
    /** @var DiceList */
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
     * @return DiceStepList
     */
    public function createList(PlayerInterface $player): DiceStepList
    {
        $activeDices = $this->diceList->getActiveItems();
        $playerDices = $this->diceList->getItemsByOwner($player);
        $stepList = new DiceStepList();

        foreach ($playerDices as $playerDice) {
            foreach ($activeDices as $activeDice) {
                if ($playerDice->canBinding($activeDice)) {
                    $stepList->addItem(new DiceStep($playerDice, $activeDice));
                }
            }
        }

        return $stepList;
    }
}
