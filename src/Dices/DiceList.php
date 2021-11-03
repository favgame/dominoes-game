<?php

namespace FavGame\DominoesGame\Dices;

use ArrayObject;
use FavGame\DominoesGame\AbstractList;
use FavGame\DominoesGame\GameRules\RulesInterface;
use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Список игральных костей
 *
 * @method ArrayObject|Dice[] getItems()
 */
final class DiceList extends AbstractList
{
    /**
     * Создать новый список игральных костей
     *
     * @param RulesInterface $gameRules Правила игры
     * @return static
     */
    public static function createInstance(RulesInterface $gameRules): self
    {
        $items = [];

        for ($sideB = 0; $sideB <= $gameRules->getMaxSideValue(); $sideB++) {
            for ($sideA = 0; $sideA <= $sideB; $sideA++) {
                $items[] = new Dice(Id::next(), new DiceSide($sideB), new DiceSide($sideA));
            }
        }

        return new self($items);
    }

    /**
     * Получить игральные кости принадлежащие конкретному игроку
     *
     * @param PlayerInterface $owner Владелец
     * @return ArrayObject|Dice[]
     */
    public function getItemsByOwner(PlayerInterface $owner): ArrayObject
    {
        $callback = fn (Dice $dice) => ($dice->getOwner() === $owner && !$dice->isUsed());

        return $this->filterItems($callback);
    }

    /**
     * Получить из набора случайную, не принадлежащию ни кому из игроков, игральную кость
     *
     * @return Dice|null Возвращает игральную кость. Либо NULL, если такой игральной кости не нашлось
     */
    public function getFreeItem(): ?Dice
    {
        $items = $this->filterItems(fn (Dice $dice) => !$dice->hasOwner());

        if ($items->count()) {
            return $items[array_rand((array) $items)];
        }

        return null;
    }

    /**
     * Получить игральные кости, находящиеся на игровом поле
     *
     * @return ArrayObject|Dice[]
     */
    public function getActiveItems(): ArrayObject
    {
        return $this->filterItems(fn (Dice $dice) => $dice->isUsed());
    }

    /**
     * Получить игральную кость с максимальным количеством очков, принадлежащую игрокам.
     * Используется для определения очереди игрока, который должен начать игру.
     *
     * @return Dice|null Возвращает игральную кость. Либо NULL, если такой игральной кости не нашлось
     */
    public function getStartItem(): ?Dice
    {
        $dice = null;
        $maxPointAmount = 0;

        foreach ($this->getItems() as $item) {
            if ($item->hasOwner() && $item->getPointAmount() >= $maxPointAmount) {
                $maxPointAmount = $item->getPointAmount();
                $dice = $item;
            }
        }

        return $dice;
    }
}
