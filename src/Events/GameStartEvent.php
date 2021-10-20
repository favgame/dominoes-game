<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\Id;

final class GameStartEvent extends AbstractEvent
{
    /** @var string */
    private const EVENT_NAME = 'Game end';

    /**
     * @var GameData
     */
    private GameData $gameData;

    /**
     * @param Id $id
     * @param GameData $gameData
     */
    public function __construct(Id $id, GameData $gameData)
    {
        $this->gameData = $gameData;

        parent::__construct($id, self::EVENT_NAME);
    }

    /**
     * @return GameData
     */
    public function getGameData(): GameData
    {
        return $this->gameData;
    }
}
