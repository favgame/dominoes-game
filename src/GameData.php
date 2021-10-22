<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;
use Dominoes\Players\ScoreList;

final class GameData
{
    /**
     * @var RulesInterface
     */
    private RulesInterface $rules;

    /**
     * @var PlayerList
     */
    private PlayerList $playerList;

    /**
     * @var ScoreList
     */
    private ScoreList $scoreList;

    /**
     * @var DiceList
     */
    private DiceList $diceList;

    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var PlayerInterface|null
     */
    private ?PlayerInterface $activePlayer;

    /**
     * @var GameState
     */
    private GameState $gameState;

    /**
     * @param Id $id
     * @param GameState $gameState
     * @param RulesInterface $rules
     * @param PlayerList $playerList
     * @param ScoreList $scoreList
     * @param DiceList $diceList
     * @param PlayerInterface|null $activePlayer
     */
    public function __construct(
        Id $id,
        GameState $gameState,
        RulesInterface $rules,
        PlayerList $playerList,
        ScoreList $scoreList,
        DiceList $diceList,
        PlayerInterface $activePlayer = null
    ) {
        $this->id = $id;
        $this->gameState = $gameState;
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->scoreList = $scoreList;
        $this->diceList = $diceList;
        $this->activePlayer = $activePlayer;
    }

    /**
     * @return Id
     */
    public function Id(): Id
    {
        return $this->id;
    }

    /**
     * @return PlayerList
     */
    public function getPlayerList(): PlayerList
    {
        return $this->playerList;
    }

    /**
     * @return RulesInterface
     */
    public function getRules(): RulesInterface
    {
        return $this->rules;
    }

    /**
     * @return DiceList
     */
    public function getDiceList(): DiceList
    {
        return $this->diceList;
    }

    /**
     * @return ScoreList
     */
    public function getScoreList(): ScoreList
    {
        return $this->scoreList;
    }

    /**
     * @return GameState
     */
    public function getState(): GameState
    {
        return $this->gameState;
    }

    /**
     * @return PlayerInterface
     * @return void
     */
    public function getActivePlayer(): PlayerInterface
    {
        return $this->activePlayer;
    }

    /**
     * @param PlayerInterface $player
     * @return void
     */
    public function setActivePlayer(PlayerInterface $player): void
    {
        $this->activePlayer = $player;
    }
}
