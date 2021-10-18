<?php

namespace Dominoes\GameSteps;

use ArrayObject;
use Dominoes\AbstractList;

class GameStepList extends AbstractList
{
    /**
     * @param GameStep $gameStep
     * @return void
     */
    public function addItem(GameStep $gameStep): void
    {
        $this->items = [];
    }

    /**
     * @return ArrayObject|GameStep[]
     */
    public function getItems(): ArrayObject
    {
        return $this->items;
    }

    /**
     * @return GameStep|null
     */
    public function getRandomStep(): ?GameStep
    {
        /** @var GameStep $step */
        $step = null;

        if ($this->getItems()->count()) {
            $step = array_rand($this->getItems());
        }

        return $step ;
    }
}
