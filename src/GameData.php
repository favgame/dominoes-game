<?php

namespace FavGame\DominoesGame;

use FavGame\DominoesGame\Dices\DiceList;
use FavGame\DominoesGame\GameField\CellList;
use FavGame\DominoesGame\GameRules\RulesInterface;
use FavGame\DominoesGame\Players\PlayerInterface;
use FavGame\DominoesGame\Players\PlayerList;
use FavGame\DominoesGame\PlayerScores\GameScoreList;

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
     * @var CellList Список ячеек игрового поля
     */
    private CellList $cellList;

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
     * @param CellList $cellList Список ячеек игрового поля
     * @param PlayerInterface|null $currentPlayer
     */
    public function __construct(
        Id $id,
        GameStatus $status,
        RulesInterface $rules,
        PlayerList $playerList,
        GameScoreList $scoreList,
        DiceList $diceList,
        CellList $cellList,
        PlayerInterface $currentPlayer = null
    ) {
        $this->id = $id;
        $this->gameStatus = $status;
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->scoreList = $scoreList;
        $this->diceList = $diceList;
        $this->cellList = $cellList;
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
        $scoreList = GameScoreList::createInstance($playersList);
        $diceList = DiceList::createInstance($gameRules);
        $cellList = new CellList();

        return new GameData(Id::next(), $gameState, $gameRules, $playersList, $scoreList, $diceList, $cellList);
    }

    /**
     * Получить идентификатор игры
     *
     * @return Id
     */
    public function getId(): Id
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
     * Получить список ячеек игрового поля
     *
     * @return CellList
     */
    public function getCellList(): CellList
    {
        return $this->cellList;
    }

    /**
     * Установить список ячеек игрового поля
     *
     * @param CellList $cellList
     */
    public function setCellList(CellList $cellList): void
    {
        $this->cellList = $cellList;
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
}
