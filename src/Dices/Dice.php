<?php

namespace FavGame\Dominoes\Dices;

use FavGame\Dominoes\Id;
use FavGame\Dominoes\Players\PlayerInterface;

/**
 * Класс игральной кости
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
     * @var bool Признак использования игральной кости
     */
    private bool $isUsed = false;

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
     * @param PlayerInterface $owner
     * @return void
     */
    public function setOwner(PlayerInterface $owner): void
    {
        $this->owner = $owner;
       // TODO: exception if owned
    }

    /**
     * Проверить возможность соединения игральных костей
     *
     * @param Dice $dice Другая гральная кость
     * @return bool
     */
    public function canBinding(self $dice): bool
    {
        if ($dice === $this ?? !$this->isUsed()) { // Первый ход в раунде
            return true;
        }

        if (!$this->isUsed() && !$dice->isUsed()) {
            return false; // Ни одна из костей
        }

        foreach ($this->getSides() as $selfSide) {
            foreach ($dice->getSides() as $diceSide) {
                if ($selfSide->canBinding($diceSide) && $diceSide->canBinding($selfSide)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Установить касание с другой игральной костью
     *
     * @param Dice $dice Другая игральная кость
     * @return void
     * @throws InvalidBindingException Бросает исключение, если касание между игральными костями невозможно
     */
    public function setBinding(self $dice): void
    {
        if (!$this->isUsed() && $dice === $this) { // Первый ход в раунде
            $this->isUsed = true;

            return;
        }

        if ($this->isUsed() || $dice->isUsed()) {
            foreach ($this->getSides() as $selfSide) {
                foreach ($dice->getSides() as $diceSide) {
                    if ($selfSide->canBinding($diceSide) && $diceSide->canBinding($selfSide)) {
                        $diceSide->setBinding($selfSide);
                        $selfSide->setBinding($diceSide);
                        $this->isUsed = true;
                        $dice->isUsed = true;

                        return;
                    }
                }
            }
        }

        throw new InvalidBindingException();
    }

    /**
     * Получить признак использования игральной кости
     *
     * @return bool Возвращает TRUE, если игральная кость была использована игроком для хода, иначе FALSE
     */
    public function isUsed(): bool
    {
        return $this->isUsed;
    }

    /**
     * Получить обе стороны игральной кости
     *
     * @return DiceSide[]
     */
    private function getSides(): array
    {
        return [$this->getSideA(), $this->getSideB()];
    }
}
