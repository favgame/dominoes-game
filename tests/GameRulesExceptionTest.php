<?php

namespace Dominoes\Tests;

use Dominoes\Game;
use Dominoes\GameDataFactory;
use Dominoes\GameRules\ClassicRules;
use Dominoes\GameRulesException;
use PHPUnit\Framework\TestCase;

final class GameRulesExceptionTest extends TestCase
{
    /**
     * @return void
     */
    public function testRun(): void
    {
        $this->expectException(GameRulesException::class);

        $gameData = (new GameDataFactory)->createGameData(new ClassicRules());
        $game = new Game($gameData);
        $game->run();
    }
}
