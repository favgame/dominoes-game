<?php

namespace Dominoes\GameSteps;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Dices\DiceList;
use Dominoes\Players\PlayerInterface;

/**
 * @method ArrayObject|Step[] getItems()
 */
final class StepList extends AbstractList
{
    /**
     * @param DiceList $diceList
     * @param PlayerInterface $player
     */
    public function __construct(DiceList $diceList, PlayerInterface $player)
    {
        $activeDices = $diceList->getActiveItems();
        $playerDices = $diceList->getItemsByOwner($player);
        $items = [];

        if ($activeDices->count() == 0) {
            $activeDices = $playerDices;
        }

        foreach ($playerDices as $playerDice) {
            foreach ($activeDices as $activeDice) {
                if ($playerDice->canBinding($activeDice)) {
                    $items[] = new Step($playerDice, $activeDice);
                }
            }
        }

        parent::__construct($items);
    }

    /**
     * @return Step|null
     */
    public function getRandomItem(): ?Step
    {
        /** @var Step $step */
        $step = null;

        if ($this->getItems()->count()) {
            $step = array_rand($this->getItems());
        }

        return $step;
    }
}
