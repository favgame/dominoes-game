<?php

namespace Dominoes\Dices;

use Dominoes\GameRules\RulesInterface;
use Dominoes\Id;

final class DiceListFactory
{
    /**
     * @var RulesInterface
     */
    private RulesInterface $rules;

    /**
     * @param RulesInterface $rules
     */
    public function __construct(RulesInterface $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return DiceList
     */
    public function createList(): DiceList
    {
        $items = [];

        for ($sideB = 0; $sideB <= $this->rules->getMaxSideValue(); $sideB++) {
            for ($sideA = 0; $sideA <= $sideB; $sideA++) {
                $items[] = new Dice(Id::next(), new DiceSide($sideB), new DiceSide($sideA));
            }
        }

        return new DiceList($items);
    }
}
