<?php

namespace FavGame\Dominoes\Players;

use FavGame\Dominoes\GameSteps\Step;
use FavGame\Dominoes\GameSteps\StepList;
use FavGame\Dominoes\Id;

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
}
