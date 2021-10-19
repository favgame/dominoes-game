<?php

namespace Dominoes\GameSteps;

use ArrayObject;
use Dominoes\AbstractList;

/**
 * @method ArrayObject|GameStep[] getItems()
 */
final class GameStepList extends AbstractList
{
    /**
     * @return GameStep|null
     */
    public function getRandomItem(): ?GameStep
    {
        /** @var GameStep $step */
        $step = null;

        if ($this->getItems()->count()) {
            $step = array_rand($this->getItems());
        }

        return $step;
    }
}
