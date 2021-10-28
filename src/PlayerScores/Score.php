<?php

namespace FavGame\Dominoes\PlayerScores;

use FavGame\Dominoes\Players\PlayerInterface;

/**
 * Игровые очки
 */
final class Score
{
    /**
     * @var PlayerInterface Игрок
     */
    private PlayerInterface $player;

    /**
     * @var int Количество очков
     */
    private int $pointAmount;

    /**
     * @param PlayerInterface $player Игрок
     * @param int $pointAmount Количество очков
     */
    public function __construct(PlayerInterface $player, int $pointAmount = 0)
    {
        $this->player = $player;
        $this->pointAmount = $pointAmount;
    }

    /**
     * Получить игрока
     *
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    /**
     * Получить кол-во игровых очков
     *
     * @return int
     */
    public function getPointAmount(): int
    {
        return $this->pointAmount;
    }

    /**
     * Установить количество игровых очков
     *
     * @param int $pointAmount
     * @return void
     */
    public function setPointAmount(int $pointAmount): void
    {
        $this->pointAmount = $pointAmount;
    }
}
