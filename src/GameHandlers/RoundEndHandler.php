<?php

namespace Dominoes\GameHandlers;

use Dominoes\GameData;

final class RoundEndHandler extends AbstractGameHandler
{
    public function handleData(GameData $gameData): void
    {
        $this->handleNext($gameData);
    }
}
