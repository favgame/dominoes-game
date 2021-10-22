<?php

namespace Dominoes;

final class GameState
{
    /** @var int */
    public const INITIAL = 0;

    /** @var int  */
    public const IN_PROGRESS = 1;

    /** @var int */
    public const DONE = 2;

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
    public function isDone(): bool
    {
        return ($this->value === self::DONE);
    }

    /**
     * @return bool
     */
    public function isInitial(): bool
    {
        return ($this->value === self::INITIAL);
    }

    /**
     * @return void
     */
    public function setValueInProgress(): void
    {
        $this->value = self::IN_PROGRESS;
    }

    /**
     * @return void
     */
    public function setValueDone(): void
    {
        $this->value = self::DONE;
    }
}
