<?php

namespace Dominoes\Events;

use Dominoes\GameData;
use Dominoes\GameSteps\GameStep;
use Dominoes\Id;

final class GameStepEvent extends AbstractGameEvent
{
    /** @var string */
    public const EVENT_NAME = 'Game step';

    /**
     * @var GameStep
     */
    private GameStep $gameStep;

    /**
     * @param Id $id
     * @param GameData $gameData
     * @param GameStep $gameStep
     */
    public function __construct(Id $id, GameData $gameData, GameStep $gameStep)
    {
        $this->gameStep = $gameStep;

        parent::__construct($id, $gameData, self::EVENT_NAME);
    }

    /**
     * @return GameStep
     */
    public function getGameStep(): GameStep
    {
        return $this->gameStep;
    }
}
