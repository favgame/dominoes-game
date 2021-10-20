<?php

namespace Dominoes\Events;

use Dominoes\Id;
use Dominoes\RoundData;

final class RoundStartEvent extends AbstractEvent
{
    use RoundDataTrait;

    /** @var string */
    private const EVENT_NAME = 'Round start';

    /**
     * @param Id $id
     * @param RoundData $roundData
     */
    public function __construct(Id $id, RoundData $roundData)
    {
        $this->roundData = $roundData;

        parent::__construct($id, self::EVENT_NAME);
    }
}
