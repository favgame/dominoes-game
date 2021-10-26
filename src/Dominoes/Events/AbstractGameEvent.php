<?php

namespace Dominoes\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Dominoes\GameData;
use Dominoes\Id;

abstract class AbstractGameEvent implements EventInterface
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * @var string
     */
    private string $eventName;

    /**
     * @var GameData
     */
    private GameData $gameData;

    /**
     * @param Id $id
     * @param DateTimeInterface $createdAt
     * @param GameData $gameData
     * @param string $eventName
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, GameData $gameData, string $eventName)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->gameData = $gameData;
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
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return GameData
     */
    public function getGameData(): GameData
    {
        return $this->gameData;
    }

    /**
     * @param mixed ...$args
     * @return EventInterface
     */
    public function createInstance(...$args): EventInterface
    {
        array_unshift($args, Id::next(), new DateTimeImmutable());

        return new static($args);
    }
}
