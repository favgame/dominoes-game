<?php

namespace FavGame\Dominoes\PlayerScores;

use FavGame\Dominoes\Players\PlayerInterface;

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
    public function __construct(PlayerInterface $player, int $pointAmount = 0)
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

    /**
     * @param int $pointAmount
     * @return void
     */
    public function setPointAmount(int $pointAmount): void
    {
        $this->pointAmount = $pointAmount;
    }
}
