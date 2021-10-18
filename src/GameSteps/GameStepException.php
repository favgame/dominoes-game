<?php

namespace Dominoes\GameSteps;

use Exception;

final class GameStepException extends Exception
{
    /** @var int */
    public const OUT_OF_DICE = 1;

    /** @var int */
    public const NO_DICE_TO_STEP = 2;

    /** @var string[] */
    private const MESSAGES = [
        self::OUT_OF_DICE => 'Out of dice',
        self::NO_DICE_TO_STEP => 'No dice to step',
    ];

    /**
     * GameStepException constructor.
     * @param int $code
     */
    public function __construct(int $code)
    {
        parent::__construct(self::MESSAGES[0], $code);
    }
}
