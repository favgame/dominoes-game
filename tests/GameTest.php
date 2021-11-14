<?php

namespace FavGame\DominoesGame\Tests;

use FavGame\DominoesGame\Bots\MelissaBot;
use FavGame\DominoesGame\Bots\SusannaBot;
use FavGame\DominoesGame\Game;
use FavGame\DominoesGame\GameData;
use FavGame\DominoesGame\GameHandlers\PlayerCountException;
use FavGame\DominoesGame\GameLogger\Logger;
use FavGame\DominoesGame\GameLogger\MessageFactory;
use FavGame\DominoesGame\GameRules\ClassicRules;
use FavGame\DominoesGame\Id;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @return void
     */
    public function testRun(): void
    {
        $gameData = GameData::createInstance(
            new ClassicRules(),
            new MelissaBot(Id::next()),
            new SusannaBot(Id::next())
        );

        $game = new Game($gameData);
        $logger = new Logger(new MessageFactory());
        $game->getEventManager()->subscribe($logger);
        $game->run();

        $this->assertIsArray($logger->getMessages());
        $this->assertNotEmpty($logger->getMessages());

        foreach ($logger->getMessages() as $message) {
            fwrite(STDOUT, $message . PHP_EOL);
        }
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
