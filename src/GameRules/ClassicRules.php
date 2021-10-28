<?php

namespace FavGame\Dominoes\GameRules;

final class ClassicRules implements RulesInterface
{
    /** @var int */
    private const MIN_PLAYERS_COUNT = 2;

    /** @var int */
    private const MAX_PLAYERS_COUNT = 4;

    /** @var int */
    private const MAX_POINT_AMOUNT = 100;

    /** @var int */
    private const MAX_SIDE_VALUE = 6;

    /** @var int */
    private const INITIAL_DICE_COUNT = 7;

    /**
     * @inheritDoc
     */
    public function getMinPlayerCount(): int
    {
        return self::MIN_PLAYERS_COUNT;
    }

    /**
     * @inheritDoc
     */
    public function getMaxPlayerCount(): int
    {
        return self::MAX_PLAYERS_COUNT;
    }

    /**
     * @return int
     */
    public function getMaxPointAmount(): int
    {
        return self::MAX_POINT_AMOUNT;
    }

    /**
     * @inheritDoc
     */
    public function getMaxSideValue(): int
    {
        return self::MAX_SIDE_VALUE;
    }

    /**
     * @inheritDoc
     */
    public function getInitialDiceCount(): int
    {
        return self::INITIAL_DICE_COUNT;
    }
}
