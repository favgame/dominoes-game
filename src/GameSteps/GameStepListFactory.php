<?php

namespace Dominoes\GameSteps;

use Dominoes\Dices\DiceList;
use Dominoes\Players\PlayerInterface;

final class GameStepListFactory
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
     * @return GameStepList
     */
    public function createList(PlayerInterface $player): GameStepList
    {
        $activeDices = $this->diceList->getActiveItems();
        $playerDices = $this->diceList->getItemsByOwner($player);
        $stepList = new GameStepList();

        foreach ($playerDices as $playerDice) {
            foreach ($activeDices as $activeDice) {
                if ($playerDice->canBinding($activeDice)) {
                    $stepList->addItem(new GameStep($playerDice, $activeDice));
                }
            }
        }

        return $stepList;
    }
}
