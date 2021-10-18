<?php

namespace Dominoes\Bots;

use Dominoes\Events\EventInterface;
use Dominoes\GameSteps\GameStep;
use Dominoes\GameSteps\GameStepList;

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
    public function doStep(GameStepList $availableSteps): ?GameStep
    {
        return $availableSteps->getRandomStep();
    }
}
