<?php

namespace FavGame\Dominoes\Players;

use FavGame\Dominoes\GameSteps\Step;
use FavGame\Dominoes\GameSteps\StepList;
use FavGame\Dominoes\Id;

interface PlayerInterface
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
