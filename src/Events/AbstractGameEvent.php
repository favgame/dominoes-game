<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\Id;

abstract class AbstractGameEvent implements EventInterface
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var GameData $gameData
     */
    private GameData $gameData;

    /**
     * @var string
     */
    private string $eventName;

    /**
     * @param Id $id
     * @param GameData $gameData
     * @param string $eventName
     */
    public function __construct(Id $id, GameData $gameData, string $eventName)
    {
        $this->id = $id;
        $this->gameData = $gameData;
        $this->eventName = $eventName;
    }

    /**
     * @inheritDoc
     */
    public final function getId(): Id
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public final function getName(): string
    {
        return $this->eventName;
    }

    /**
     * @return GameData
     */
    public final function getGameData(): GameData
    {
        return $this->gameData;
    }
}
