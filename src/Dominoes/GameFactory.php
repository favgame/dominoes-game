<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;
use Dominoes\PlayerScores\ScoreList;

final class GameFactory
{
    /**
     * @param RulesInterface $gameRules
     * @param PlayerInterface ...$players
     * @return Game
     */
    public function createGame(RulesInterface $gameRules, PlayerInterface ...$players): Game
    {
        $gameState = new GameState();
        $playersList = new PlayerList($players);
        $scoreList = new ScoreList($playersList);
        $diceList = new DiceList($gameRules);
        $gameData = new GameData(Id::next(), $gameState, $gameRules, $playersList, $scoreList, $diceList);

        return new Game($gameData);
    }
}
