<?php

namespace Dominoes\Events;

use DateTimeInterface;
use Dominoes\Dices\Dice;
use Dominoes\GameData;
use Dominoes\Id;

final class DiceGivenEvent extends AbstractGameEvent
{
    /** @var string */
    public const EVENT_NAME = 'Dice given';

    /**
     * @var Dice
     */
    private Dice $dice;

    /**
     * @param Id $id
     * @param DateTimeInterface $createdAt
     * @param GameData $gameData
     * @param Dice $dice
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData, Dice $dice)
    {
        $this->dice = $dice;

        parent::__construct($id, $createdAt, $gameData, self::EVENT_NAME);
    }

    /**
     * @return Dice
     */
    public function getDice(): Dice
    {
        return $this->dice;
    }
}
