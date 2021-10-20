<?php

namespace Dominoes\Events;

use Dominoes\RoundData;

trait RoundDataTrait
{
    /**
     * @var RoundData
     */
    protected RoundData $roundData;

    /**
     * @return RoundData
     */
    public function getRoundData(): RoundData
    {
        return $this->roundData;
    }
}
