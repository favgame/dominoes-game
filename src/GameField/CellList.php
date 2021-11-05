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
     * @param Dice $dice
     * @return ArrayObject|Cell[]
     */
    public function getItemsByDice(Dice $dice): ArrayObject
    {
        return $this->filterItems(fn (Cell $item) => $item->getLeftDice() === $dice || $item->getRightDice() === $dice);
    }

    /**
     * @return ArrayObject|Cell[]
     */
    public function getFreeCells(): ArrayObject
    {
        return $this->filterItems(fn (Cell $item) => !$item->hasRightDice());
    }

    /**
     * @param Cell $item
     * @return void
     */
    public function addItem(Cell $item): void
    {
        $this->items[] = $item;
    }
}
