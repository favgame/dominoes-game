<?php

namespace Dominoes\GameSteps;

use ArrayObject;
use Dominoes\AbstractList;

/**
 * @method ArrayObject|Step[] getItems()
 */
final class StepList extends AbstractList
{
    /**
     * @return Step|null
     */
    public function getRandomItem(): ?Step
    {
        /** @var Step $step */
        $step = null;

        if ($this->getItems()->count()) {
            $step = array_rand($this->getItems());
        }

        return $step;
    }
}
