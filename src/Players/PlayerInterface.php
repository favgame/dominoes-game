<?php

namespace Dominoes\Players;

use Dominoes\Dices\DiceStep;
use Dominoes\Dices\DiceStepList;
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
     * @param DiceStepList $availableSteps
     * @return DiceStep
     */
    public function doStep(DiceStepList $availableSteps): ?DiceStep;
}
