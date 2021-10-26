<?php

namespace Tests\Dominoes;

use Dominoes\Bots\MelissaBot;
use Dominoes\Bots\SusannaBot;
use Dominoes\Game;
use Dominoes\GameDataFactory;
use Dominoes\GameRules\ClassicRules;
use Dominoes\Id;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @return void
     */
    public function testRun(): void
    {
        $inWork = true;
        $gameData = (new GameDataFactory)->createGameData(
            new ClassicRules(),
            new MelissaBot(Id::next()),
            new SusannaBot(Id::next())
        );
        $game = new Game($gameData);

        while ($inWork) {
            $inWork = $game->run();
            $this->assertIsBool($inWork);
        }
    }
}
