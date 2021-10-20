<?php

namespace Dominoes;

use Dominoes\Dices\Dice;
use Dominoes\Dices\DiceList;
use Dominoes\Dices\DiceSide;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerList;

final class GameFactory
{
    public function createGame(RulesInterface $gameRules): Game
    {
        $playersList = new PlayerList();
        $diceList = $this->createDiceList($gameRules);
        $gameData = new GameData($gameRules, $playersList, $diceList);

        return new Game($gameData);
    }

    /**
     * @param RulesInterface $gameRules
     * @return DiceList
     */
    private function createDiceList(RulesInterface $gameRules): DiceList
    {
        $items = [];

        for ($sideB = 0; $sideB <= $gameRules->getMaxSideValue(); $sideB++) {
            for ($sideA = 0; $sideA <= $sideB; $sideA++) {
                $items[] = new Dice(Id::next(), new DiceSide($sideB), new DiceSide($sideA));
            }
        }

        return new DiceList($items);
    }
}
