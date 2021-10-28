<?php

namespace FavGame\Dominoes\Bots;

use FavGame\Dominoes\GameSteps\Step;
use FavGame\Dominoes\GameSteps\StepList;
use FavGame\Dominoes\Id;

/**
 * Компьютерный соперник
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
        return $availableSteps->getRandomItem();
    }
}
