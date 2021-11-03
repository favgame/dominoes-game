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
     * @var static|null Касание с другой стороной другой игральной кости
     */
    private ?self $binding = null;

    /**
     * @param int $value Количество очков стороны игральной кости
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Проверить возможность соединения сторон игральных костей
     *
     * @param DiceSide $side
     * @return bool
     */
    public function canBinding(self $side): bool
    {
        if ($side === $this || $this->binding !== null || $side->getValue() != $this->getValue()) {
            return false;
        }

        return true;
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

    /**
     * Установить касание с другой стороной другой игральной кости
     *
     * @param DiceSide $side Сторона другой игральной кости
     * @return void
     * @throws InvalidBindingException Бросает исключение, если касание между сторонами игральных костей невозможно
     */
    public function setBinding(self $side): void
    {
        if (!$this->canBinding($side)) {
            throw new InvalidBindingException();
        }

        $this->binding = $side;
    }
}
