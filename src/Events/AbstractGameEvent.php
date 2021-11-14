<?php

namespace FavGame\DominoesGame\Events;

use DateTimeInterface;
use FavGame\DominoesGame\Id;

/**
 * Абстрактное игровок событие
 */
abstract class AbstractGameEvent implements EventInterface
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
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param string $eventName Название события
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, string $eventName)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
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
