<?php

namespace Dominoes;

use Dominoes\Dices\Dice;
use Dominoes\Dices\DiceList;
use Dominoes\Dices\DiceSide;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;
use Dominoes\Players\ScoreList;
use Dominoes\PlayerScores\Score;

final class GameFactory
{
    public function createGame(RulesInterface $gameRules): Game
    {
        $playersList = new PlayerList();
        $diceList = $this->createDiceList($gameRules);
        $scoreList = $this->createScoreList($playersList);
        $gameData = new GameData(Id::next(), $gameRules, $playersList, $scoreList, $diceList);

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

    /**
     * @param PlayerList $playerList
     * @return ScoreList
     */
    private function createScoreList(PlayerList $playerList): ScoreList
    {
        $items = array_map(fn (PlayerInterface $player) => new Score($player), $playerList->getItems());

        return new ScoreList($items);
    }
}
