<?php

namespace FavGame\Dominoes;

use FavGame\Dominoes\Dices\DiceList;
use FavGame\Dominoes\GameRules\RulesInterface;
use FavGame\Dominoes\Players\PlayerInterface;
use FavGame\Dominoes\Players\PlayerList;
use FavGame\Dominoes\PlayerScores\ScoreList;

/**
 * Фабрика
 */
final class GameDataFactory
{
    /**
     * @param RulesInterface $gameRules
     * @param PlayerInterface ...$players
     * @return GameData
     */
    public function createGameData(RulesInterface $gameRules, PlayerInterface ...$players): GameData
    {
        $gameState = new GameStatus();
        $playersList = new PlayerList($players);
        $scoreList = new ScoreList($playersList);
        $diceList = new DiceList($gameRules);

        return new GameData(Id::next(), $gameState, $gameRules, $playersList, $scoreList, $diceList);
    }
}
