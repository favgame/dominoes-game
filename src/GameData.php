<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\Dices\DiceListFactory;
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
     * @param PlayerList $playerList
     */
    public function __construct(GameRulesInterface $rules, PlayerList $playerList)
    {
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->diceList = (new DiceListFactory())->createDiceList($this->rules->getMaxSideValue());
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
     * @return void
     */
    public function setActivePlayer(PlayerInterface $player): void
    {
        $this->activePlayer = $player;
    }
}
