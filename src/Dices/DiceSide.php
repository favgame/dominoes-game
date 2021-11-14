<?php

namespace FavGame\DominoesGame\Dices;

/**
 * Сторона игральной кости
 */
final class DiceSide
{
    /**
     * @var int Количество очков стороны игральной кости
     */
    private int $value;

    /**
     * @param int $value Количество очков стороны игральной кости
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Получить количество очков стороны игральной кости
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
