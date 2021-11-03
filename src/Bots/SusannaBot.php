<?php

namespace FavGame\DominoesGame\Bots;

use FavGame\DominoesGame\GameSteps\Step;
use FavGame\DominoesGame\GameSteps\StepList;
use FavGame\DominoesGame\Id;

/**
 * Компьютерный соперник
 */
final class SusannaBot extends AbstractBot
{
    /** @var string */
    private const PLAYER_NAME = 'Bot Susanna';

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
        return $availableSteps->getRandomItem();
    }
}
