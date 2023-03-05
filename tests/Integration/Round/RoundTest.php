<?php

namespace Tests\Integration\FavGame\DominoesGame\Round;

use FavGame\DominoesGame\Dice\Dice;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Round\Round;
use FavGame\DominoesGame\Round\RoundState;
use FavGame\DominoesGame\Rules\GameRulesInterface;
use FavGame\DominoesGame\ServiceContainer;
use PHPUnit\Framework\TestCase;

class RoundTest extends TestCase
{
    private ServiceContainer $container;
    
    private PlayerQueue $queue;
    
    private GameRulesInterface $rules;
    
    private Round $round;
    
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
        
        $this->rules = $this->container->getClassicRules();
        $this->queue = $this->container->getPlayerQueue([$this->player1, $this->player2]);
        $this->round = $this->container->createRound($this->queue, $this->container->getDiceList($this->dices));
    }
    
    public function testUpdateState(): void
    {
        $this->assertEquals($this->round->getState(), RoundState::initial);
        $this->round->updateState($this->rules, $this->queue);
        $this->assertEquals($this->round->getState(), RoundState::inProgress);
        // 1
        $this->assertEquals($this->queue->getCurrent(), $this->player2);
        $dices = $this->round->getDiceList()->inHands($this->player2);
        $this->assertCount(2, $dices);
        $steps = $this->round->getField()->getAvailableSteps($dices);
        $this->assertCount(2, $steps);
        $this->round->getField()->applyStep($steps->getStepWithMaxPoints());
        $this->assertCount(2, $this->round->getField());
        $this->queue->changeNext();
        // 2
        $this->assertEquals($this->queue->getCurrent(), $this->player1);
        $dices = $this->round->getDiceList()->inHands($this->player1);
        $this->assertCount(2, $dices);
        $steps = $this->round->getField()->getAvailableSteps($dices);
        $this->assertCount(2, $steps);
        $this->round->getField()->applyStep($steps->getStepWithMaxPoints());
        $this->assertCount(3, $this->round->getField());
        $this->queue->changeNext();
        // 3
        $this->assertEquals($this->queue->getCurrent(), $this->player2);
        $dices = $this->round->getDiceList()->inHands($this->player2);
        $this->assertCount(1, $dices);
        $steps = $this->round->getField()->getAvailableSteps($dices);
        $this->assertCount(1, $steps);
        $this->round->getField()->applyStep($steps->getStepWithMaxPoints());
        $this->assertCount(4, $this->round->getField());
        $this->queue->changeNext();
        
        $this->round->updateState($this->rules, $this->queue);
        $this->assertTrue($this->round->getState()->isComplete());
    }
}
