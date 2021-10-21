<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\GameRules\RulesInterface;
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
     * @param Id $id
     * @param RulesInterface $rules
     * @param PlayerList $playerList
     * @param ScoreList $scoreList
     * @param DiceList $diceList
     */
    public function __construct(
        Id $id,
        RulesInterface $rules,
        PlayerList $playerList,
        ScoreList $scoreList,
        DiceList $diceList
    ) {
        $this->id = $id;
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->scoreList = $scoreList;
        $this->diceList = $diceList;
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
}
