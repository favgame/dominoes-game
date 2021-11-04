<?php

namespace FavGame\DominoesGame\Dices;

use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Игральная кость
 */
final class Dice
{
    /**
     * @var Id Идентификатор игральной кости
     */
    private Id $id;

    /**
     * @var DiceSide Первая сторона игральной кости
     */
    private DiceSide $sideA;

    /**
     * @var DiceSide Вторая сторона игральной кости
     */
    private DiceSide $sideB;

    /**
     * @var int Сумма очков обоих сторон игральной кости
     */
    private int $pointAmount;

    /**
     * @var PlayerInterface|null Текущий владелец игральной кости
     */
    private ?PlayerInterface $owner = null;

    /**
     * @param Id $id Идентификатор игральной кости
     * @param DiceSide $sideA Первая сторона игральной кости
     * @param DiceSide $sideB Вторая сторона игральной кости
     */
    public function __construct(Id $id, DiceSide $sideA, DiceSide $sideB)
    {
        $this->id = $id;
        $this->sideA = $sideA;
        $this->sideB = $sideB;
        $this->pointAmount = $this->sideA->getValue() + $this->sideB->getValue();
    }

    /**
     * Получить идентификатор игральной кости
     *
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * Получить первую сторону игральной кости
     *
     * @return DiceSide
     */
    public function getSideA(): DiceSide
    {
        return $this->sideA;
    }

    /**
     * Получить второю сторону игральной кости
     *
     * @return DiceSide
     */
    public function getSideB(): DiceSide
    {
        return $this->sideB;
    }

    /**
     * Получить суммарное количество очков обоих сторон кости
     *
     * @return int
     */
    public function getPointAmount(): int
    {
        return $this->pointAmount;
    }

    /**
     * Получить текущего владельца кости
     *
     * @return PlayerInterface|null
     */
    public function getOwner(): ?PlayerInterface
    {
        return $this->owner;
    }

    /**
     * Проверить признак владения кости
     *
     * @return bool Возвращает TRUE, если кость принадлежит игроку, иначе FALSE
     */
    public function hasOwner(): bool
    {
        return ($this->owner !== null);
    }

    /**
     * Установить текущего владельца кости
     *
     * @param PlayerInterface|null $owner
     * @return void
     */
    public function setOwner(?PlayerInterface $owner): void
    {
        $this->owner = $owner;
    }
}
