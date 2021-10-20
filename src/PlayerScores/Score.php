<?php

namespace Dominoes\PlayerScores;

use Dominoes\Players\PlayerInterface;

final class Score
{
    /**
     * @var PlayerInterface
     */
    private PlayerInterface $player;

    /**
     * @var int
     */
    private int $pointAmount;

    /**
     * @param PlayerInterface $player
     * @param int $pointAmount
     */
    public function __construct(PlayerInterface $player, int $pointAmount)
    {
        $this->player = $player;
        $this->pointAmount = $pointAmount;
    }

    /**
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getPointAmount(): int
    {
        return $this->pointAmount;
    }
}
