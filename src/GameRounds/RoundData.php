<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\Players\PlayerList;

final class RoundData
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var PlayerList
     */
    private PlayerList $playerList;

    /**
     * @var DiceList
     */
    private DiceList $diceList;

    /**
     * @param Id $id
     * @param PlayerList $playerList
     * @param DiceList $diceList
     */
    public function __construct(Id $id, DiceList $diceList, PlayerList $playerList)
    {
        $this->id = $id;
        $this->playerList = $playerList;
        $this->diceList = $diceList;
    }

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
     * @return DiceList
     */
    public function getDiceList(): DiceList
    {
        return $this->diceList;
    }
}
