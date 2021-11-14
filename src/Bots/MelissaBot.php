<?php

namespace FavGame\DominoesGame\Bots;

use FavGame\DominoesGame\GameSteps\Step;
use FavGame\DominoesGame\GameSteps\StepList;
use FavGame\DominoesGame\Id;

/**
 * Компьютерный соперник, который всегда выбирает для хода игральную кость с наибольшим количеством очков
 */
final class MelissaBot extends AbstractBot
{
    /** @var string Имя игрока */
    private const PLAYER_NAME = 'Bot Melissa';

    /**
     * @param Id $id Идентификатор игрока
     */
    public function __construct(Id $id)
    {
        parent::__construct($id, self::PLAYER_NAME);
    }

    /**
     * @inheritDoc
     */
    public function getStep(StepList $availableSteps): ?Step
    {
        $step = null;

        foreach ($availableSteps->getItems() as $item) {
            if ($step === null || $item->getChosenDice()->getPointAmount() > $step->getChosenDice()->getPointAmount()) {
                $step = $item;
            }
        }

        return $step;
    }
}
