<?php

namespace FavGame\Dominoes\Events;

use DateTimeInterface;
use FavGame\Dominoes\GameData;
use FavGame\Dominoes\Id;

final class RoundStartEvent extends AbstractGameEvent
{
    /** @var string */
    private const EVENT_NAME = 'Round start';

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
