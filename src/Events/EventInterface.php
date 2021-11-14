<?php

namespace FavGame\DominoesGame\Events;

use FavGame\DominoesGame\Id;
use DateTimeInterface;

/**
 * Интерфейс события
 */
interface EventInterface
{
    /**
     * Получить идентификатор события
     *
     * @return Id
     */
    public function getId(): Id;

    /**
     * Получить название события
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Получить дату создания события
     *
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface;
}
