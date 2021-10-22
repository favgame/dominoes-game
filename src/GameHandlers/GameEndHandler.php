<?php

namespace Dominoes\GameHandlers;

use Dominoes\GameData;

final class GameEndHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(GameData $gameData): void
    {
        $this->handleNext($gameData);
    }
}
