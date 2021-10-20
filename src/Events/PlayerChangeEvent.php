<?php

namespace Dominoes\Events;

use Dominoes\Id;
use Dominoes\Players\PlayerInterface;
use Dominoes\RoundData;

final class PlayerChangeEvent extends AbstractEvent
{
    use RoundDataTrait;

    /** @var string */
    public const EVENT_NAME = 'Player change';

    /**
     * @var PlayerInterface
     */
    private PlayerInterface $player;

    /**
     * @param Id $id
     * @param RoundData $roundData
     * @param PlayerInterface $player
     */
    public function __construct(Id $id, RoundData $roundData, PlayerInterface $player)
    {
        $this->roundData = $roundData;
        $this->player = $player;

        parent::__construct($id, self::EVENT_NAME);
    }

    /**
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }
}
