<?php

namespace FavGame\DominoesGame\Events;

use FavGame\DominoesGame\GameSteps\Step;

/**
 * Событие хода игрока
 */
final class GameStepEvent extends AbstractEvent
{
    /** @var string Название события */
    public const EVENT_NAME = 'Game step';

    /**
     * @var Step Ход игрока
     */
    private Step $gameStep;

    /**
     * @param Step $gameStep Ход игрока
     */
    public function __construct(Step $gameStep)
    {
        $this->gameStep = $gameStep;

        parent::__construct(self::EVENT_NAME);
    }

    /**
     * Получить игровой ход
     *
     * @return Step
     */
    public function getGameStep(): Step
    {
        return $this->gameStep;
    }
}
