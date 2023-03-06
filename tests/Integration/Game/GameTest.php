<?php

namespace Tests\Integration\FavGame\DominoesGame\Game;

use FavGame\DominoesGame\Dice\Dice;
use FavGame\DominoesGame\Game\Game;
use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Round\Round;
use FavGame\DominoesGame\Round\RoundList;
use FavGame\DominoesGame\Rules\GameRulesInterface;
use FavGame\DominoesGame\ServiceContainer;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    private ServiceContainer $container;
    
    private PlayerQueue $queue;
    
    private GameRulesInterface $rules;
    
    private Round $round;
    
    private RoundList $rounds;
    
    private Game $game;
    
    private GameData $gameData;
    
    private Player $player1;
    
    private Player $player2;
    
    /**
     * @var Dice[]
     */
    private array $dices;
    
    protected function setUp(): void
    {
        $this->container = new ServiceContainer();
        $this->player1 = $this->container->getPlayer('player one');
        $this->player2 = $this->container->getPlayer('player two');
        $this->dices = [
            new Dice(5, 6), // Второй ход Первого игрока
            new Dice(6, 6), // Первый ход Второго игрока
            new Dice(5, 5), // Остаток в руке Первого игрока
            new Dice(4, 5), // Третий ход Второго игрока
        ];
        
        $this->rules = $this->createMock(GameRulesInterface::class);
        $this->rules->method('getMinPlayerCount')->willReturn(2);
        $this->rules->method('getMaxPlayerCount')->willReturn(4);
        $this->rules->method('getMaxScoreAmount')->willReturn(1);
        $this->rules->method('getMaxSideValue')->willReturn(6);
        $this->rules->method('getInitialDiceCount')->willReturn(2);
        
        $this->queue = $this->container->getPlayerQueue([$this->player1, $this->player2]);
        $this->round = $this->container->createRound($this->queue, $this->container->getDiceList($this->dices));
        $this->rounds = $this->container->getRoundList([$this->round]);
        $this->gameData = $this->container->getGameData($this->queue, $this->rules, $this->rounds);
        $this->game = $this->container->getGame($this->gameData);
    }
    
    public function testGame(): void
    {
        $this->assertTrue($this->round->getState()->isInitial());
        $this->game->beginGame();
        $this->assertTrue($this->round->getState()->isInProgress());
        // 1
        $this->assertEquals($this->player2, $this->queue->getCurrent());
        $dices = $this->round->getDiceList()->inHands($this->player2);
        $this->assertCount(2, $dices);
        $steps = $this->game->getSteps($this->player2);
        $this->assertCount(2, $steps);
        $this->game->takeStep($steps->getStepWithMaxPoints());
        $this->assertCount(2, $this->round->getField());
        // 2
        $this->assertEquals($this->player1, $this->queue->getCurrent());
        $dices = $this->round->getDiceList()->inHands($this->player1);
        $this->assertCount(2, $dices);
        $steps = $this->game->getSteps($this->player1);
        $this->assertCount(2, $steps);
        $this->game->takeStep($steps->getStepWithMaxPoints());
        $this->assertCount(3, $this->round->getField());
        // 3
        $this->assertEquals($this->player2, $this->queue->getCurrent());
        $dices = $this->round->getDiceList()->inHands($this->player2);
        $this->assertCount(1, $dices);
        $steps = $this->game->getSteps($this->player2);
        $this->assertCount(1, $steps);
        $this->game->takeStep($steps->getStepWithMaxPoints());
        $this->assertCount(4, $this->round->getField());
        
        $this->assertTrue($this->round->getState()->isComplete());
    }
}
