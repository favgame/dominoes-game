<?php

namespace Tests\Integration\FavGame\DominoesGame\Round;

use FavGame\DominoesGame\Dice\Dice;
use FavGame\DominoesGame\Dice\DiceList;
use FavGame\DominoesGame\Dice\DiceState;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Round\InvalidPlayerException;
use FavGame\DominoesGame\Round\InvalidStateException;
use FavGame\DominoesGame\Round\Round;
use FavGame\DominoesGame\ServiceContainer;
use PHPUnit\Framework\TestCase;

class RoundTest extends TestCase
{
    private ServiceContainer $container;
    
    private PlayerQueue $queue;
    
    private Round $round;
    
    private Player $player1;
    
    private Player $player2;
    
    private DiceList $diceList;
    
    protected function setUp(): void
    {
        $this->container = new ServiceContainer();
        $this->player1 = $this->container->getPlayer('player one');
        $this->player2 = $this->container->getPlayer('player two');
        $this->diceList = $this->container->getDiceList([
            new Dice(5, 6, DiceState::inHand, $this->player1), // Второй ход Первого игрока
            new Dice(6, 6, DiceState::inHand, $this->player2), // Первый ход Второго игрока
            new Dice(5, 5, DiceState::inHand, $this->player1), // Остаток в руке Первого игрока
            new Dice(4, 5, DiceState::inHand, $this->player2), // Третий ход Второго игрока
        ]);
        
        $this->rules = $this->container->getClassicRules();
        $this->queue = $this->container->getPlayerQueue([$this->player2, $this->player1]);
        $this->round = $this->container->createRound($this->queue, $this->diceList);
    }
    
    public function testTakeStep(): void
    {
        $this->assertTrue($this->round->getState()->isInitial());
        $this->round->setInProgress();
        $this->assertTrue($this->round->getState()->isInProgress());
        $this->assertEquals($this->queue->getCurrent(), $this->player2);
        $dices = $this->diceList->inHands($this->player2);
        $this->assertCount(2, $dices);
        $steps = $this->round->getSteps($this->queue, $this->player2);
        $this->assertCount(2, $steps);
        //
        $this->round->takeStep($this->queue, $steps->getStepWithMaxPoints());
        //
        $dices = $this->diceList->inHands($this->player2);
        $this->assertCount(1, $dices);
        //
        $this->assertEquals($this->queue->getCurrent(), $this->player1);
    }
    
    public function testTakeStepInvalidState(): void
    {
        $this->assertEquals($this->queue->getCurrent(), $this->player2);
        $this->assertTrue($this->round->getState()->isInitial());
        $steps = $this->round->getField()->getAvailableSteps($this->diceList->inHands($this->player2));
        $this->expectException(InvalidStateException::class);
        $this->round->takeStep($this->queue, $steps->getStepWithMaxPoints());
    }
    
    public function testTakeStepInvalidPlayer(): void
    {
        $this->assertEquals($this->queue->getCurrent(), $this->player2);
        $this->round->setInProgress();
        $this->assertTrue($this->round->getState()->isInProgress());
        $steps = $this->round->getField()->getAvailableSteps($this->diceList->inHands($this->player1));
        $this->expectException(InvalidPlayerException::class);
        $this->round->takeStep($this->queue, $steps->getStepWithMaxPoints());
    }
}
