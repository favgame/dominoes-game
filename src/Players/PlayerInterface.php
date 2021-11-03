<?php

namespace FavGame\DominoesGame\Players;

use FavGame\DominoesGame\GameSteps\Step;
use FavGame\DominoesGame\GameSteps\StepList;
use FavGame\DominoesGame\Id;

/**
 * Интерфейс игрока
 */
interface PlayerInterface
{
    /**
     * Получить идентификатор игрока
     *
     * @return Id
     */
    public function getId(): Id;

    /**
     * Получить имя игрока
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Получить ход игрока
     *
     * @param StepList $availableSteps Список доступных игровых ходов
     * @return Step|null Возвращает выбранный игровой ход из списка доступных, либо NULL, если ход не сделан
     */
    public function getStep(StepList $availableSteps): ?Step;

    /**
     * @return bool
     */
    public function isBot(): bool;
}
