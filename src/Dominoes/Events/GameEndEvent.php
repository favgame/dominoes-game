<?php

namespace Dominoes\Events;

use DateTimeImmutable;
use Dominoes\GameData;
use Dominoes\Id;

final class GameEndEvent extends AbstractGameEvent
{
    /** @var string */
    private const EVENT_NAME = 'Game end';

    /**
     * @param Id $id
     * @param DateTimeImmutable $dateTimeImmutable
     * @param GameData $gameData
     */
    public function __construct(Id $id, DateTimeImmutable $dateTimeImmutable, GameData $gameData)
    {
        parent::__construct($id, $dateTimeImmutable, $gameData, self::EVENT_NAME);
    }
}
