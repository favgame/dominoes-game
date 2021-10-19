<?php

namespace Dominoes\Bots;

use Dominoes\GameSteps\GameStep;
use Dominoes\GameSteps\GameStepList;
use Dominoes\Events\EventInterface;

final class MelissaBot extends AbstractBot
{
    /** @var string */
    private const PLAYER_NAME = 'Bot Melissa';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::PLAYER_NAME;
    }

    /**
     * @inheritDoc
     */
    public function handleEvent(EventInterface $event): void
    {

    }

    /**
     * @inheritDoc
     */
    public function getStep(GameStepList $availableSteps): ?GameStep
    {
        return $availableSteps->getRandomItem();
    }
}
