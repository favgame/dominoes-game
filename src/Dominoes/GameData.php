<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;
use Dominoes\PlayerScores\ScoreList;

final class GameData
{
    /**
     * @var RulesInterface Правила игры
     */
    private RulesInterface $rules;

    /**
     * @var PlayerList Список игроков
     */
    private PlayerList $playerList;

    /**
     * @var ScoreList Список игровых очков
     */
    private ScoreList $scoreList;

    /**
     * @var DiceList Список игральных костей
     */
    private DiceList $diceList;

    /**
     * @var Id Идентификатор игры
     */
    private Id $id;

    /**
     * @var PlayerInterface|null Текущий игрок
     */
    private ?PlayerInterface $activePlayer; // TODO: переименовать в $currentPlayer

    /**
     * @var GameState Текущее состояние игры
     */
    private GameState $gameState;

    /**
     * @param Id $id Идентификатор игры
     * @param GameState $gameState Текущее состояние игры
     * @param RulesInterface $rules Правила игры
     * @param PlayerList $playerList Список игроков
     * @param ScoreList $scoreList Список игровых очков
     * @param DiceList $diceList Список игральных костей
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
     * Получить идентификатор игры
     *
     * @return Id
     */
    public function Id(): Id
    {
        return $this->id;
    }

    /**
     * Получить список игроков
     *
     * @return PlayerList
     */
    public function getPlayerList(): PlayerList
    {
        return $this->playerList;
    }

    /**
     * Получить правила игры
     *
     * @return RulesInterface
     */
    public function getRules(): RulesInterface
    {
        return $this->rules;
    }

    /**
     * Получить список игральных костей
     *
     * @return DiceList
     */
    public function getDiceList(): DiceList
    {
        return $this->diceList;
    }

    /**
     * Установить список игральных костей
     *
     * @param DiceList $diceList
     */
    public function setDiceList(DiceList $diceList): void
    {
        $this->diceList = $diceList;
    }

    /**
     * Получить список игровых очков
     *
     * @return ScoreList
     */
    public function getScoreList(): ScoreList
    {
        return $this->scoreList;
    }

    /**
     * Получить текущее состояние игры
     *
     * @return GameState
     */
    public function getState(): GameState
    {
        return $this->gameState;
    }

    /**
     * Получить текущего игрока
     *
     * @return PlayerInterface|null
     * @return void
     */
    public function getActivePlayer(): ?PlayerInterface
    {
        return $this->activePlayer;
    }

    /**
     * Установить текущего игрока
     *
     * @param PlayerInterface|null $player
     * @return void
     */
    public function setActivePlayer(?PlayerInterface $player): void
    {
        $this->activePlayer = $player;
    }
}
