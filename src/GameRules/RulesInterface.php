<?php

namespace FavGame\DominoesGame\GameRules;

/**
 * Интерфейс игровых правил
 */
interface RulesInterface
{
    /**
     * Получить минимальное кол-во игроков, необходимых для игры
     *
     * @return int
     */
    public function getMinPlayerCount(): int;

    /**
     * Получить миаксимальное кол-во игроков, необходимых для игры
     *
     * @return int
     */
    public function getMaxPlayerCount(): int;

    /**
     * Получить количество очков, необходимых для победы
     *
     * @return int
     */
    public function getMaxPointAmount(): int;

    /**
     * Получить максимальное значение стороны игральной кости
     *
     * @return int
     */
    public function getMaxSideValue(): int;

    /**
     * Получить количество игральных костей, получаемых игроками в начале раунда
     *
     * @return int
     */
    public function getInitialDiceCount(): int;
}
