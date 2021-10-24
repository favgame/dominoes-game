<?php

namespace Dominoes\Bots;

use Dominoes\Events\EventInterface;
use Dominoes\GameSteps\Step;
use Dominoes\GameSteps\StepList;
use Dominoes\Id;

final class SusannaBot extends AbstractBot
{
    /** @var string */
    private const PLAYER_NAME = 'Bot Susanna';

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
    public function handleEvent(EventInterface $event): void
    {

    }

    /**
     * @inheritDoc
     */
    public function getStep(StepList $availableSteps): ?Step
    {
        return $availableSteps->getRandomItem();
    }
}
