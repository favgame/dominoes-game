<?php

namespace Dominoes\GameHandlers;

use Dominoes\GameData;

interface HandlerInterface
{
    /**
     * @param GameData $gameData
     * @return void
     */
    public function handleData(GameData $gameData): void;

    /**
     * @param HandlerInterface $handler
     * @return void
     */
    public function setNextHandler(self $handler): void;
}
