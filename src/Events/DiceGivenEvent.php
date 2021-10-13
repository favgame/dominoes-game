<?php

namespace Dominoes\Events;

use Dominoes\Dices\Dice;
use Dominoes\Id;

final class DiceGivenEvent implements EventInterface
{
    /** @var string */
    public const EVENT_NAME = 'Dice given';

    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var Dice
     */
    private Dice $dice;

    /**
     * @param Id $id
     * @param Dice $dice
     */
    public function __construct(Id $id, Dice $dice)
    {
        $this->id = $id;
        $this->dice = $dice;
    }

    /**
     * @inheritDoc
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::EVENT_NAME;
    }

    /**
     * @return Dice
     */
    public function getDice(): Dice
    {
        return $this->dice;
    }
}
