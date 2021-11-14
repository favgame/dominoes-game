<?php

namespace FavGame\DominoesGame\GameField;

use ArrayObject;
use FavGame\DominoesGame\AbstractList;
use FavGame\DominoesGame\Dices\Dice;

/**
 * Список ячеек игрового поля
 *
 * @method ArrayObject|Cell[] getItems()
 */
final class CellList extends AbstractList
{
    /**
     * Получить список ячеек игрового поля, в которых находится игральная кость
     *
     * @param Dice $dice Игральная кость
     * @return ArrayObject|Cell[] Возвращает массив ячеек игрового поля
     */
    public function getItemsByDice(Dice $dice): ArrayObject
    {
        return $this->filterItems(fn (Cell $item) => $item->getLeftDice() === $dice || $item->getRightDice() === $dice);
    }

    /**
     * Получить список свободных ячеек игрового поля
     *
     * @return ArrayObject|Cell[]
     */
    public function getFreeCells(): ArrayObject
    {
        return $this->filterItems(fn (Cell $item) => !$item->hasRightDice());
    }

    /**
     * Добавить в список ячейку игрового поля
     *
     * @param Cell $item Ячейка игрового поля
     * @return void
     */
    public function addItem(Cell $item): void
    {
        $this->items[] = $item;
    }
}
