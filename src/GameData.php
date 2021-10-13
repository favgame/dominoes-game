<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\GameRulesInterface;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;

final class GameData
{
    /**
     * @var GameRulesInterface
     */
    private GameRulesInterface $rules;

    /**
     * @var PlayerList
     */
    private PlayerList $playerList;

    /**
     * @var DiceList
     */
    private DiceList $diceList;

    /**
     * @var PlayerInterface|null
     */
    private ?PlayerInterface $activePlayer = null;

    /**
     * @param GameRulesInterface $rules
     * @param DiceList $diceList
     * @param PlayerList $playerList
     */
    public function __construct(GameRulesInterface $rules, DiceList $diceList, PlayerList $playerList)
    {
        $this->rules = $rules;
        $this->diceList = $diceList;
        $this->playerList = $playerList;
    }

    /**
     * @return PlayerList
     */
    public function getPlayerList(): PlayerList
    {
        return $this->playerList;
    }

    /**
     * @return GameRulesInterface
     */
    public function getRules(): GameRulesInterface
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
     * @return PlayerInterface|null
     */
    public function getActivePlayer(): ?PlayerInterface
    {
        return $this->activePlayer;
    }

    /**
     * @param PlayerInterface $player
     */
    public function setActivePlayer(PlayerInterface $player): void
    {
        $this->activePlayer = $player;
    }
}
