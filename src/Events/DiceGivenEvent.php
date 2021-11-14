<?php

namespace FavGame\DominoesGame\Events;

use FavGame\DominoesGame\Dices\Dice;

/**
 * Событие получения игральной кости
 */
final class DiceGivenEvent extends AbstractEvent
{
    /** @var string Название события */
    public const EVENT_NAME = 'Dice given';

    /**
     * @var Dice Игральная кость
     */
    private Dice $dice;

    /**
     * @param Dice $dice Игральная кость
     */
    public function __construct(Dice $dice)
    {
        $this->dice = $dice;

        parent::__construct(self::EVENT_NAME);
    }

    /**
     * Получить игральную кость
     *
     * @return Dice
     */
    public function getDice(): Dice
    {
        return $this->dice;
    }
}
