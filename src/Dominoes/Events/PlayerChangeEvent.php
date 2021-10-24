<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

final class PlayerChangeEvent extends AbstractGameEvent
{
    /** @var string */
    public const EVENT_NAME = 'Player change';

    /**
     * @var PlayerInterface
     */
    private PlayerInterface $player;

    /**
     * @param Id $id
     * @param GameData $gameData
     * @param PlayerInterface $player
     */
    public function __construct(Id $id, GameData $gameData, PlayerInterface $player)
    {
        $this->player = $player;

        parent::__construct($id, $gameData, self::EVENT_NAME);
    }

    /**
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }
}
