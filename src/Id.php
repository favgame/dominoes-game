<?php

namespace FavGame\DominoesGame;

/**
 * Идентификатор
 */
final class Id
{
    /**
     * @var int Целочисленное значение идентификатора
     */
    private int $value;

    /**
     * @param int $value Целочисленное значение идентификатора
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Получить значение идентификатора
     *
     * @return int Целочисленное значение идентификатора
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Создать новый экземпляр
     *
     * @return static
     */
    public static function next(): self
    {
        return new self(hexdec(uniqid()));
    }
}
