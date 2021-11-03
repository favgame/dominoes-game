<?php

namespace FavGame\DominoesGame\GameSteps;

use ArrayObject;
use FavGame\DominoesGame\AbstractList;
use FavGame\DominoesGame\Dices\DiceList;
use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Список доступных игровых шагов
 *
 * @method ArrayObject|Step[] getItems()
 */
final class StepList extends AbstractList
{
    /**
     * Создать список доступных игровых шагов
     *
     * @param DiceList $diceList Список игральных костей
     * @param PlayerInterface $player Игрок, для которого будут расчитаны ходы
     * @return self
     */
    public static function createInstance(DiceList $diceList, PlayerInterface $player): self
    {
        $activeDices = $diceList->getActiveItems();
        $playerDices = $diceList->getItemsByOwner($player);
        $items = [];

        foreach ($playerDices as $playerDice) {
            if ($activeDices->count() == 0) {
                $items[] = new Step($playerDice, $playerDice);

                continue;
            }

            foreach ($activeDices as $activeDice) {
                if ($playerDice->canBinding($activeDice)) {
                    $items[] = new Step($playerDice, $activeDice);
                }
            }
        }

        return new self($items);
    }

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
