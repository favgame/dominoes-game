<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\GameRulesInterface;
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
     * @param GameRulesInterface $rules
     * @param PlayerList $playerList
     */
    public function __construct(GameRulesInterface $rules, PlayerList $playerList)
    {
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->diceList = DiceList::createInstance($this->rules->getMaxSideValue());
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
}
