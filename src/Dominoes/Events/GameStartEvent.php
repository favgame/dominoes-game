<?php

namespace Dominoes\Events;

use DateTimeInterface;
use Dominoes\GameData;
use Dominoes\Id;

final class GameStartEvent extends AbstractGameEvent
{
    /** @var string */
    private const EVENT_NAME = 'Game start';

    /**
     * @param Id $id
     * @param DateTimeInterface $createdAt
     * @param GameData $gameData
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData)
    {
        parent::__construct($id, $createdAt, $gameData, self::EVENT_NAME);
    }
}