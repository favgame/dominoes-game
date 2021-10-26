<?php

namespace Dominoes\Events;

use DateTimeInterface;
use Dominoes\GameData;
use Dominoes\GameSteps\Step;
use Dominoes\Id;

final class GameStepEvent extends AbstractGameEvent
{
    /** @var string */
    public const EVENT_NAME = 'Game step';

    /**
     * @var Step
     */
    private Step $gameStep;

    /**
     * @param Id $id
     * @param DateTimeInterface $createdAt
     * @param GameData $gameData
     * @param Step $gameStep
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData, Step $gameStep)
    {
        $this->gameStep = $gameStep;

        parent::__construct($id, $createdAt, $gameData, self::EVENT_NAME);
    }

    /**
     * @return Step
     */
    public function getGameStep(): Step
    {
        return $this->gameStep;
    }
}
