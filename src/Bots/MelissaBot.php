<?php

namespace Dominoes\Bots;

use Dominoes\Dices\DiceStep;
use Dominoes\Dices\DiceStepList;
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
    public function doStep(DiceStepList $availableSteps): ?DiceStep
    {
        return $availableSteps->getRandomItem();
    }
}
