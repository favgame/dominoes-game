<?php

namespace Dominoes\Events;

use Dominoes\Id;

abstract class AbstractEvent implements EventInterface
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var string
     */
    private string $eventName;

    /**
     * @param Id $id
     * @param string $eventName
     */
    public function __construct(Id $id, string $eventName)
    {
        $this->id = $id;
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
}
