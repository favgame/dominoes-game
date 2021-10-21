<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\Id;

final class GameStartEvent extends AbstractGameEvent
{
    /** @var string */
    private const EVENT_NAME = 'Game start';

    /**
     * @param Id $id
     * @param GameData $gameData
     */
    public function __construct(Id $id, GameData $gameData)
    {
        parent::__construct($id, $gameData, self::EVENT_NAME);
    }
}
