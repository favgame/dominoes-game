<?php

namespace Dominoes\Players;

use Dominoes\Events\EventListenerInterface;

use Dominoes\GameSteps\GameStep;
use Dominoes\GameSteps\GameStepList;
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
     * @return GameStep|null
     */
    public function doStep(GameStepList $availableSteps): ?GameStep;
}
