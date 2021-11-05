<?php

namespace FavGame\DominoesGame\GameField;

use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceSide;
use FavGame\DominoesGame\Id;

/**
 * Ячейка игрового поля
 */
final class Cell
{
    /**
     * @var Id Идентификатор ячейки
     */
    private Id $id;

    /**
     * @var Dice Левая игральная кость
     */
    private Dice $leftDice;

    /**
     * @var Dice|null Правая игральная кость
     */
    private ?Dice $rightDice = null;

    /**
     * @var int Значение ячейки
     */
    private int $value;

    /**
     * @param Id $id Идентификатор ячейки
     * @param Dice $leftDice Левая игральная кость
     * @param DiceSide $diceSide Одна из сторон игральной кости
     */
    public function __construct(Id $id, Dice $leftDice, DiceSide $diceSide)
    {
        $this->id = $id;
        $this->leftDice = $leftDice;
        $this->value = $diceSide->getValue();
    }

    /**
     * Получить значение ячейки
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Получить идентификатор ячейки
     *
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * Получить левую игральную кость
     *
     * @return Dice
     */
    public function getLeftDice(): Dice
    {
        return $this->leftDice;
    }

    /**
     * Получить правую игральную кость
     *
     * @return Dice|null
     */
    public function getRightDice(): ?Dice
    {
        return $this->rightDice;
    }

    /**
     * Проверить наличие правой игральной кости
     *
     * @return bool
     */
    public function hasRightDice(): bool
    {
        return ($this->rightDice !== null);
    }

    /**
     * Установить правую игральную кость
     *
     * @param Dice $dice Игральная кость
     * @return void
     * @throws InvalidAllocationException
     */
    public function setRightDice(Dice $dice): void
    {
        if (!$this->canSetRightDice($dice)) {
            throw new InvalidAllocationException();
        }

        $this->rightDice = $dice;
    }

    /**
     * Проверить возможность установки правой игральной кости
     *
     * @param Dice $dice Игральная кость
     * @return bool
     */
    public function canSetRightDice(Dice $dice): bool
    {
        if (!in_array($this->value, [$dice->getSideA()->getValue(), $dice->getSideB()->getValue()])) {
            return false;
        }

        if ($this->hasRightDice() || $dice === $this->leftDice) {
            return false;
        }

        return true;
    }
}
