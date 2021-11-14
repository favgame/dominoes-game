<?php

namespace FavGame\DominoesGame\Events;

use DateTimeInterface;
use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Id;

/**
 * Событие получения игральной кости
 */
final class DiceGivenEvent extends AbstractGameEvent
{
    /** @var string Название события */
    public const EVENT_NAME = 'Dice given';

    /**
     * @var Dice Игральная кость
     */
    private Dice $dice;

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param Dice $dice Игральная кость
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, Dice $dice)
    {
        $this->dice = $dice;

        parent::__construct($id, $createdAt, self::EVENT_NAME);
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
