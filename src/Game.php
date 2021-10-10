<?php

namespace Dominos;

use Dominos\GameRules\GameRulesInterface;
use Dominos\Players\PlayersList;

final class Game
{
    private GameRulesInterface $rules;

    private PlayerList $playerList;

    public function __construct(GameRulesInterface $rules, PlayerList $playerList)
    {
        $this->rules = $rules;
        $this->playerList = $playerList;
    }

    public function run(): void
    {

    }

    public function getPlayerList(): PlayerList
    {
        return $this->playerList;
    }

    public function getRules(): GameRulesInterface
    {
        return $this->rules;
    }
}
