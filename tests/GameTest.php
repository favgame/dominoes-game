<?php

namespace FavGame\Dominoes\Tests;

use FavGame\Dominoes\Bots\MelissaBot;
use FavGame\Dominoes\Bots\SusannaBot;
use FavGame\Dominoes\Game;
use FavGame\Dominoes\GameData;
use FavGame\Dominoes\GameLogger\Logger;
use FavGame\Dominoes\GameLogger\MessageFactory;
use FavGame\Dominoes\GameRules\ClassicRules;
use FavGame\Dominoes\Id;
use FavGame\Dominoes\PlayerCountException;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @return void
     */
    public function testRun(): void
    {
        $inWork = true;
        $gameData = GameData::createInstance(
            new ClassicRules(),
            new MelissaBot(Id::next()),
            new SusannaBot(Id::next())
        );
        $logger = new Logger(new MessageFactory());
        $game = new Game($gameData);
        $game->getEventManager()->subscribe($logger);

        while ($inWork) {
            $inWork = $game->run();
        }

        $this->assertIsArray($logger->getMessages());
        $this->assertNotEmpty($logger->getMessages());
    }

    /**
     * @return void
     */
    public function testPlayerCount(): void
    {
        $this->expectException(PlayerCountException::class);
        $gameData = GameData::createInstance(
            new ClassicRules(),
            new MelissaBot(Id::next())
        );
        $game = new Game($gameData);
        $game->run();
    }
}
