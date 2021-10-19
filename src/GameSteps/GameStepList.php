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
     * @param GameStep $gameStep
     * @return void
     */
    public function addItem(GameStep $gameStep): void
    {
        $this->items[] = $gameStep;
    }

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
