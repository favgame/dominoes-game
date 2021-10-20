<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\RulesInterface;
use Dominoes\Players\PlayerList;

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
     * @var DiceList
     */
    private DiceList $diceList;

    /**
     * @param RulesInterface $rules
     * @param PlayerList $playerList
     * @param DiceList $diceList
     */
    public function __construct(
        RulesInterface $rules,
        PlayerList $playerList,
        DiceList $diceList
    ) {
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->diceList = $diceList;
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
}
