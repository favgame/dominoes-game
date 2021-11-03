<?php

namespace FavGame\DominoesGame\GameLogger;

use FavGame\DominoesGame\Events\EventInterface;
use FavGame\DominoesGame\Events\EventListenerInterface;

final class Logger implements EventListenerInterface
{
    /**
     * @var string[] Буффер сообщений
     */
    private array $messages = [];

    /**
     * @var MessageFactoryInterface Фабрика сообщений
     */
    private MessageFactoryInterface $messageFactory;

    /**
     * @param MessageFactoryInterface $messageFactory Фабрика сообщений
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
     * Получить буффер созданных сообщений
     *
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
