<?php

namespace FavGame\Dominoes\GameLogger;

use FavGame\Dominoes\Events\EventInterface;
use FavGame\Dominoes\Events\EventListenerInterface;

final class Logger implements EventListenerInterface
{
    /**
     * @var string[]
     */
    private array $messages = [];

    /**
     * @var MessageFactoryInterface
     */
    private MessageFactoryInterface $messageFactory;

    /**
     * @param MessageFactoryInterface $messageFactory
     */
    public function __construct(MessageFactoryInterface $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * @inheritDoc
     */
    public function handleEvent(EventInterface $event): void
    {
        $this->messages[] = $this->messageFactory->createMessage($event);
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
