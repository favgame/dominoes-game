<?php

namespace Dominoes\Events;

use Dominoes\GameSteps\Step;
use Dominoes\Id;
use Dominoes\RoundData;

final class GameStepEvent extends AbstractEvent
{
    use RoundDataTrait;

    /** @var string */
    public const EVENT_NAME = 'Game step';

    /**
     * @var Step
     */
    private Step $gameStep;

    /**
     * @param Id $id
     * @param RoundData $roundData
     * @param Step $gameStep
     */
    public function __construct(Id $id, RoundData $roundData, Step $gameStep)
    {
        $this->roundData = $roundData;
        $this->gameStep = $gameStep;

        parent::__construct($id, self::EVENT_NAME);
    }

    /**
     * @return Step
     */
    public function getGameStep(): Step
    {
        return $this->gameStep;
    }
}
