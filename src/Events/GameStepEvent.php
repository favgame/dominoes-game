<?php

namespace FavGame\DominoesGame\Events;

use DateTimeInterface;
use FavGame\DominoesGame\GameSteps\Step;
use FavGame\DominoesGame\Id;

/**
 * Событие хода игрока
 */
final class GameStepEvent extends AbstractGameEvent
{
    /** @var string Название события */
    public const EVENT_NAME = 'Game step';

    /**
     * @var Step Ход игрока
     */
    private Step $gameStep;

    /**
     * @param Id $id Идентификатор события
     * @param DateTimeInterface $createdAt Дата создания события
     * @param Step $gameStep Ход игрока
     */
    public function __construct(Id $id, DateTimeInterface $createdAt, Step $gameStep)
    {
        $this->gameStep = $gameStep;

        parent::__construct($id, $createdAt, self::EVENT_NAME);
    }

    /**
     * @return Step
     */
    public function getGameStep(): Step
    {
        return $this->gameStep;
    }
}
