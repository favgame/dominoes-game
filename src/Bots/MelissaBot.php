<?php

namespace Dominoes\Bots;

use Dominoes\GameSteps\GameStep;
use Dominoes\GameSteps\GameStepList;
use Dominoes\Events\EventInterface;
use Dominoes\Id;

final class MelissaBot extends AbstractBot
{
    /** @var string */
    private const PLAYER_NAME = 'Bot Melissa';

    /**
     * @param Id $id
     * @param string $name
     */
    public function __construct(Id $id, string $name)
    {
        parent::__construct($id, self::PLAYER_NAME);
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
