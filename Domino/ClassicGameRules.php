<?php

namespace Domino;

final class ClassicGameRules implements GameRulesInterface
{
    private const MIN_PLAYERS_COUNT = 2;

    private const MAX_PLAYERS_COUNT = 4;

    public function getMinPlayersCount(): int
    {
        return self::MIN_PLAYERS_COUNT;
    }

    public function getMaxPlayersCount(): int
    {
        return self::MAX_PLAYERS_COUNT;
    }
}
