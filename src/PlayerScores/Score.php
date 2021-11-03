<?php

namespace FavGame\DominoesGame\PlayerScores;

use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Игровые очки
 */
final class Score
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var PlayerInterface Игрок
     */
    private PlayerInterface $player;

    /**
     * @var int Количество очков
     */
    private int $pointAmount;

    /**
     * @param Id $id Идентификатор игровых очков
     * @param PlayerInterface $player Игрок
     * @param int $pointAmount Количество очков
     */
    public function __construct(Id $id, PlayerInterface $player, int $pointAmount = 0)
    {
        $this->id = $id;
        $this->player = $player;
        $this->pointAmount = $pointAmount;
    }

    /**
     * Получить идентификатор игровых очков
     *
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
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
