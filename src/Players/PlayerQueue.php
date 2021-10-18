<?php

namespace Dominoes\Players;

use Dominoes\GameData;

final class PlayerQueue
{
    /**
     * @var GameData
     */
    private GameData $gameData;

    /**
     * @param GameData $gameData
     */
    public function __construct(GameData $gameData)
    {
        $this->gameData = $gameData;
    }
}
