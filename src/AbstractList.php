<?php

namespace FavGame\DominoesGame;

use ArrayObject;

/**
 * Абстрактный список
 */
abstract class AbstractList
{
    /**
     * @var array хранимый массив элементов списка
     */
    protected array $items = [];

    /**
     * @param array $items Массив элементов списка
     */
    public final function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Получить элементы списка
     *
     * @return ArrayObject
     */
    public function getItems(): ArrayObject
    {
        return new ArrayObject($this->items);
    }

    /**
     * Отфильтровать элементы списка
     *
     * @param callable $callable Функция обратного вызова
     * @return ArrayObject
     * @see array_filter()
     */
    protected function filterItems(callable $callable): ArrayObject
    {
        $items = array_filter($this->items, $callable);

        return new ArrayObject($items);
    }

    /**
     * Проверить, находится ли элемент в текущем списке
     *
     * @param mixed $item Элемент
     * @return bool Возвращает TRUE, слемент находится в списке, иначе FALSE
     */
    public function hasItem($item): bool
    {
        return (array_search($item, $this->items, true) !== null);
    }

    /**
     * Применить заданную функцию к каждому элементу списка
     *
     * @param callable $callback Функция обратного вызова
     * @return void
     * @see array_walk()
     */
    public function eachItems(callable $callback): void
    {
        array_walk($this->items, $callback);
    }
}
