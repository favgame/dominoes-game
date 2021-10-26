<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;
use Dominoes\PlayerScores\ScoreList;

final class GameDataFactory
{
    /**
     * @param RulesInterface $gameRules
     * @param PlayerInterface ...$players
     * @return GameData
     */
    public function createGameData(RulesInterface $gameRules, PlayerInterface ...$players): GameData
    {
        $gameState = new GameState();
        $playersList = new PlayerList($players);
        $scoreList = new ScoreList($playersList);
        $diceList = new DiceList($gameRules);

        return new GameData(Id::next(), $gameState, $gameRules, $playersList, $scoreList, $diceList);
    }
}
