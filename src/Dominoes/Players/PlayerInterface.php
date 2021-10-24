<?php

namespace Dominoes\Players;

use Dominoes\GameSteps\Step;
use Dominoes\GameSteps\StepList;
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
     * @param StepList $availableSteps
     * @return Step
     */
    public function getStep(StepList $availableSteps): ?Step;
}
