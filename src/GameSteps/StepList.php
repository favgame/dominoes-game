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
}
