<?php

namespace Dominoes\Tests;

use Dominoes\Bots\MelissaBot;
use Dominoes\Bots\SusannaBot;
use Dominoes\Game;
use Dominoes\GameDataFactory;
use Dominoes\GameLogger\Logger;
use Dominoes\GameLogger\MessageFactory;
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
        $logger = new Logger(new MessageFactory());
        $game = new Game($gameData);
        $game->getEventManager()->subscribe($logger);

        while ($inWork) {
            $inWork = $game->run();
            $this->assertIsBool($inWork);
        }
    }
}
