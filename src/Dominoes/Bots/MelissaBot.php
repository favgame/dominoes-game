<?php

namespace Dominoes\Bots;

use Dominoes\GameSteps\Step;
use Dominoes\GameSteps\StepList;
use Dominoes\Id;

final class MelissaBot extends AbstractBot
{
    /** @var string */
    private const PLAYER_NAME = 'Bot Melissa';

    /**
     * @param Id $id
     */
    public function __construct(Id $id)
    {
        parent::__construct($id, self::PLAYER_NAME);
    }

    /**
     * @inheritDoc
     */
    public function getStep(StepList $availableSteps): ?Step
    {
        return $availableSteps->getRandomItem();
    }
}
