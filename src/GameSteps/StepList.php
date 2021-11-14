<?php

namespace FavGame\DominoesGame\GameSteps;

use ArrayObject;
use FavGame\DominoesGame\AbstractList;

/**
 * Список доступных игровых шагов
 *
 * @method ArrayObject|Step[] getItems()
 */
final class StepList extends AbstractList
{
    /**
     * Получить случайный игровой ход
     *
     * @return Step|null Возвращает случайный игровой ход, если он есть. Либо NULL в случае его отсутствия
     */
    public function getRandomItem(): ?Step
    {
        /** @var Step $step */
        $step = null;

        if (count($this->items)) {
            $randomKey = array_rand($this->items);
            $step = $this->items[$randomKey];
        }

        return $step;
    }

    /**
     * Проверить, находится ли элемент в текущем списке
     *
     * @param Step $step Элемент
     * @return bool Возвращает TRUE, слемент находится в списке, иначе FALSE
     */
    public function hasStep(Step $step): bool
    {
        $items = $this->filterItems(function (Step $item) use ($step) {
            $diceIsEqual = $item->getChosenDice() === $step->getChosenDice();
            $cellIsEqual = $item->getDestinationCell() === $step->getDestinationCell();

            return ($diceIsEqual && $cellIsEqual);
        });

        return ($items->count() > 0);
    }
}
