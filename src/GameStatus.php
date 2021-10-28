<?php

namespace FavGame\Dominoes;

/**
 * Статус игры
 */
final class GameStatus
{
    /** @var int */
    public const INITIAL_STATUS = 0; // Начальный статус игры

    /** @var int */
    public const READY_STATUS = 1; // Предыдущий раунд закончен

    /** @var int  */
    public const IN_PROGRESS_STATUS = 2; // Игроки делают ходы

    /** @var int */
    public const DONE_STATUS = 3; // Игра окончена

    /**
     * @var int Целочисленное значение статуса
     */
    private int $value;

    /**
     * @param int $value Целочисленное значение статуса
     */
    public function __construct(int $value = self::INITIAL_STATUS)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isInitial(): bool
    {
        return ($this->value === self::INITIAL_STATUS);
    }

    /**
     * @return bool
     */
    public function isReady(): bool
    {
        return ($this->value === self::READY_STATUS);
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return ($this->value === self::DONE_STATUS);
    }

    /**
     * Установить текущий статус
     *
     * @return void
     */
    public function setReady(): void
    {
        $this->value = self::READY_STATUS;
    }

    /**
     * Установить текущий статус
     *
     * @return void
     */
    public function setInProgress(): void
    {
        $this->value = self::IN_PROGRESS_STATUS;
    }

    /**
     * Установить текущий статус
     *
     * @return void
     */
    public function setDone(): void
    {
        $this->value = self::DONE_STATUS;
    }
}
