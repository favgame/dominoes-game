<?php

namespace Dominoes\Players;

use Dominoes\GameSteps\GameStep;
use Dominoes\GameSteps\GameStepList;
use Dominoes\Events\EventListenerInterface;
use Dominoes\Id;

interface PlayerInterface extends EventListenerInterface
{
    /**
     * @return Id
     */
    public function getId(): Id;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param GameStepList $availableSteps
     * @return GameStep
     */
    public function getStep(GameStepList $availableSteps): ?GameStep;
}
