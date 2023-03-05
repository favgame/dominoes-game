<?php

namespace FavGame\DominoesGame\Rules;

/**
 * Интерфейс игровых правил
 */
interface GameRulesInterface
{
    /**
     * Получить минимальное кол-во игроков, необходимых для игры
     *
     * @return int
     */
    public function getMinPlayerCount(): int;
    
    /**
     * Получить максимальное кол-во игроков, необходимых для игры
     *
     * @return int
     */
    public function getMaxPlayerCount(): int;
    
    /**
     * Получить количество очков, необходимых для победы
     *
     * @return int
     */
    public function getMaxScoreAmount(): int;
    
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
