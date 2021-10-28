<?php

namespace FavGame\Dominoes\Events;

use DateTimeInterface;
use FavGame\Dominoes\Dices\Dice;
use FavGame\Dominoes\GameData;
use FavGame\Dominoes\Id;

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
     * @param GameData $gameData Игровые данные
     * @param Dice $dice Игральная кость
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData, Dice $dice)
    {
        $this->dice = $dice;

        parent::__construct($id, $createdAt, $gameData, self::EVENT_NAME);
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
