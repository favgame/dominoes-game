<?php

namespace FavGame\Dominoes;

use FavGame\Dominoes\Dices\DiceList;
use FavGame\Dominoes\GameRules\RulesInterface;
use FavGame\Dominoes\Players\PlayerInterface;
use FavGame\Dominoes\Players\PlayerList;
use FavGame\Dominoes\PlayerScores\GameScoreList;

/**
 * Игровые данные
 */
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
     * @var GameScoreList Список игровых очков
     */
    private GameScoreList $scoreList;

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
    private ?PlayerInterface $currentPlayer;

    /**
     * @var GameStatus Текущее состояние игры
     */
    private GameStatus $gameStatus;

    /**
     * @param Id $id Идентификатор игры
     * @param GameStatus $status Текущее состояние игры
     * @param RulesInterface $rules Правила игры
     * @param PlayerList $playerList Список игроков
     * @param GameScoreList $scoreList Список игровых очков
     * @param DiceList $diceList Список игральных костей
     * @param PlayerInterface|null $currentPlayer
     */
    public function __construct(
        Id $id,
        GameStatus $status,
        RulesInterface $rules,
        PlayerList $playerList,
        GameScoreList $scoreList,
        DiceList $diceList,
        PlayerInterface $currentPlayer = null
    ) {
        $this->id = $id;
        $this->gameStatus = $status;
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->scoreList = $scoreList;
        $this->diceList = $diceList;
        $this->currentPlayer = $currentPlayer;
    }

    /**
     * @param RulesInterface $gameRules
     * @param PlayerInterface ...$players
     * @return GameData
     */
    public static function createInstance(RulesInterface $gameRules, PlayerInterface ...$players): GameData
    {
        $gameState = new GameStatus();
        $playersList = new PlayerList($players);
        $scoreList = new GameScoreList($playersList);
        $diceList = new DiceList($gameRules);

        return new GameData(Id::next(), $gameState, $gameRules, $playersList, $scoreList, $diceList);
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
     * @return GameScoreList
     */
    public function getScoreList(): GameScoreList
    {
        return $this->scoreList;
    }

    /**
     * Получить текущей статус игры
     *
     * @return GameStatus
     */
    public function getStatus(): GameStatus
    {
        return $this->gameStatus;
    }

    /**
     * Получить текущего игрока
     *
     * @return PlayerInterface|null
     * @return void
     */
    public function getCurrentPlayer(): ?PlayerInterface
    {
        return $this->currentPlayer;
    }

    /**
     * Установить текущего игрока
     *
     * @param PlayerInterface|null $player
     * @return void
     */
    public function setCurrentPlayer(?PlayerInterface $player): void
    {
        $this->currentPlayer = $player;
    }

    /**
     * @return bool
     */
    public function hasCurrentPlayer(): bool
    {
        return ($this->currentPlayer !== null);
    }
}
