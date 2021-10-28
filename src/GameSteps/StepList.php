<?php

namespace FavGame\Dominoes\GameSteps;

use ArrayObject;
use FavGame\Dominoes\AbstractList;
use FavGame\Dominoes\Dices\DiceList;
use FavGame\Dominoes\Players\PlayerInterface;

/**
 * Список достпных игровых шагов
 *
 * @method ArrayObject|Step[] getItems()
 */
final class StepList extends AbstractList
{
    /**
     * @param DiceList $diceList Список игральных костей
     * @param PlayerInterface $player Игрок, для которого будут расчитаны ходы
     */
    public function __construct(DiceList $diceList, PlayerInterface $player)
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

        parent::__construct($items);
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
