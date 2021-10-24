<?php

namespace Dominoes;

final class GameState
{
    /** @var int */
    public const INITIAL = 0;

    /** @var int */
    public const READY = 1;

    /** @var int  */
    public const IN_PROGRESS = 2;

    /** @var int */
    public const DONE = 3;

    /**
     * @var int
     */
    private int $value;

    /**
     * @param int $value
     */
    public function __construct(int $value = self::INITIAL)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isInitial(): bool
    {
        return ($this->value === self::INITIAL);
    }

    /**
     * @return bool
     */
    public function isReady(): bool
    {
        return ($this->value === self::READY);
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return ($this->value === self::DONE);
    }

    /**
     * @return void
     */
    public function setReady(): void
    {
        $this->value = self::READY;
    }

    /**
     * @return void
     */
    public function setInProgress(): void
    {
        $this->value = self::IN_PROGRESS;
    }

    /**
     * @return void
     */
    public function setDone(): void
    {
        $this->value = self::DONE;
    }
}
