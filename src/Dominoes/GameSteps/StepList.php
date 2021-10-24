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


        foreach ($playerDices as $playerDice) {
            if ($activeDices->count() == 0) {
                $items[] = new Step($playerDice, $playerDice);

                continue;
            }

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

        if (count($this->items)) {
            $randomKey = array_rand($this->items);
            $step = $this->items[$randomKey];
        }

        return $step;
    }
}
