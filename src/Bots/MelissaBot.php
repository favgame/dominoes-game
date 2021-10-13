<?php

namespace Dominoes\Bots;

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

    public function handleEvent(EventInterface $event): void
    {

    }
}
