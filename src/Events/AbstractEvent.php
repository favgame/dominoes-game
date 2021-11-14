<?php

namespace FavGame\DominoesGame\Events;

use DateTimeImmutable;
use DateTimeInterface;
use FavGame\DominoesGame\Id;

/**
 * Абстрактное игровок событие
 */
abstract class AbstractEvent implements EventInterface
{
    /**
     * @var Id Идентификатор события
     */
    private Id $id;

    /**
     * @var DateTimeInterface Дата создания события
     */
    private DateTimeInterface $createdAt;

    /**
     * @var string Название события
     */
    private string $eventName;

    /**
     * @param string $eventName Название события
     */
    public function __construct(string $eventName)
    {
        $this->id = Id::next();
        $this->createdAt = new DateTimeImmutable();
        $this->eventName = $eventName;
    }

    /**
     * @inheritDoc
     */
    public final function getId(): Id
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public final function getName(): string
    {
        return $this->eventName;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
