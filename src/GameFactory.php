<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerList;
use Dominoes\Players\ScoreList;

final class GameFactory
{
    /**
     * @param RulesInterface $gameRules
     * @return Game
     */
    public function createGame(RulesInterface $gameRules): Game
    {
        $gameState = new GameState();
        $playersList = new PlayerList();
        $scoreList = new ScoreList($playersList);
        $diceList = new DiceList($gameRules);
        $gameData = new GameData(Id::next(), $gameState, $gameRules, $playersList, $scoreList, $diceList);

        return new Game($gameData);
    }
}
