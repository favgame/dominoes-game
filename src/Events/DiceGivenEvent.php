<?php

namespace Dominoes\Events;

use Dominoes\Dices\Dice;
use Dominoes\Id;
use Dominoes\RoundData;

final class DiceGivenEvent extends AbstractEvent
{
    use RoundDataTrait;

    /** @var string */
    public const EVENT_NAME = 'Dice given';

    /**
     * @var Dice
     */
    private Dice $dice;

    /**
     * @param Id $id
     * @param RoundData $roundData
     * @param Dice $dice
     */
    public function __construct(Id $id, RoundData $roundData, Dice $dice)
    {
        $this->roundData = $roundData;
        $this->dice = $dice;

        parent::__construct($id, self::EVENT_NAME);
    }

    /**
     * @return Dice
     */
    public function getDice(): Dice
    {
        return $this->dice;
    }
}
