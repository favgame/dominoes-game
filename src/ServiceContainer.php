<?php

namespace FavGame\DominoesGame;

use FavGame\DominoesGame\Dice\Dice;
use FavGame\DominoesGame\Dice\DiceDistributor;
use FavGame\DominoesGame\Dice\DiceGenerator;
use FavGame\DominoesGame\Dice\DiceList;
use FavGame\DominoesGame\Event\EventDispatcher;
use FavGame\DominoesGame\Event\EventDispatcherInterface;
use FavGame\DominoesGame\Event\EventManager;
use FavGame\DominoesGame\Event\GameEvent;
use FavGame\DominoesGame\Event\GameEventFactoryInterface;
use FavGame\DominoesGame\Event\GameEventType;
use FavGame\DominoesGame\Field\Collision;
use FavGame\DominoesGame\Field\CollisionFactoryInterface;
use FavGame\DominoesGame\Field\GameField;
use FavGame\DominoesGame\Field\GameStep;
use FavGame\DominoesGame\Field\GameStepFactoryInterface;
use FavGame\DominoesGame\Field\GameStepList;
use FavGame\DominoesGame\Game\Game;
use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Game\GameScore;
use FavGame\DominoesGame\Game\Handler\RoundCompleteHandler;
use FavGame\DominoesGame\Game\Handler\RoundInitialHandler;
use FavGame\DominoesGame\Game\Handler\RoundInProgressHandler;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Player\PlayerScore;
use FavGame\DominoesGame\Round\Round;
use FavGame\DominoesGame\Round\RoundData;
use FavGame\DominoesGame\Round\RoundFactoryInterface;
use FavGame\DominoesGame\Round\RoundScore;
use FavGame\DominoesGame\Rules\ClassicRules;
use FavGame\DominoesGame\Rules\GameRulesInterface;

class ServiceContainer implements
    RoundFactoryInterface,
    CollisionFactoryInterface,
    GameStepFactoryInterface,
    GameEventFactoryInterface
{
    private EventDispatcherInterface $eventDispatcher;
    
    private EventManager $eventManager;
    
    private DiceDistributor $diceDistributor;
    
    public function __construct()
    {
        $this->eventDispatcher = new EventDispatcher();
        $this->eventManager = new EventManager($this->eventDispatcher, $this);
        $this->diceDistributor = new DiceDistributor($this->eventManager);
        
    }
    
    public function getDiceDistributor(): DiceDistributor
    {
        return $this->diceDistributor;
    }
    
    public function getEventManager(): EventManager
    {
        return $this->eventManager;
    }
    
    public function getClassicRules(): GameRulesInterface
    {
        return new ClassicRules();
    }
    
    public function getDice(int $sideA, int $sideB): Dice
    {
        return new Dice($sideA, $sideB);
    }
    
    public function getDiceList(array $dices = null): DiceList
    {
        if ($dices === null) {
            $items = $this->getDiceGenerator()->generateItems();
    
            shuffle($items);
    
            $callback = fn (array $side) => $this->getDice($side[0], $side[1]);
            $dices = array_map($callback, $items);
        }
        
        return new DiceList($dices);
    }
    
    public function getDiceGenerator(): DiceGenerator
    {
        return new DiceGenerator($this->getClassicRules());
    }
    
    public function getGameField(array $collisions = []): GameField
    {
        return new GameField($this->getEventManager(), $this, $this, $collisions);
    }
    
    public function getPlayer(string $name): Player
    {
        return new Player($name);
    }
    
    public function getPlayerQueue(array $players = []): PlayerQueue
    {
        return new PlayerQueue($this->getEventManager(), $players);
    }
    
    public function getPlayerScore(Player $player): PlayerScore
    {
        return new PlayerScore($player);
    }
    
    public function getRoundScore(PlayerQueue $queue): RoundScore
    {
        $playersScore = [];
        
        foreach ($queue as $player) {
            $playersScore[] = $this->getPlayerScore($player);
        }
        
        return new RoundScore($playersScore);
    }
    
    public function getRoundData(PlayerQueue $queue, DiceList $diceList = null): RoundData
    {
        return new RoundData($diceList ?: $this->getDiceList(), $this->getRoundScore($queue), $this->getGameField());
    }
    
    public function createRound(PlayerQueue $queue, DiceList $diceList = null): Round
    {
        return new Round($this->getDiceDistributor(), $this->getRoundData($queue, $diceList));
    }
    
    public function createCollision(int $value, Dice $diceA, Dice $diceB = null): Collision
    {
        return new Collision($value, $diceA, $diceB);
    }
    
    public function createGameStep(Dice $dice, Collision|null $collision): GameStep
    {
        return new GameStep($dice, $collision);
    }
    
    public function createGameStepList(array $steps): GameStepList
    {
        return new GameStepList($steps);
    }
    
    public function createEvent(GameEventType $type, ...$params): GameEvent
    {
        return new GameEvent($type, ...$params);
    }
    
    public function getGameScore(PlayerQueue $queue): GameScore
    {
        $playersScore = [];
        
        foreach ($queue as $player) {
            $playersScore[] = $this->getPlayerScore($player);
        }
    
        return new GameScore($playersScore);
    }
    
    public function getGameData(PlayerQueue $queue, array $rounds = []): GameData
    {
        return new GameData(
            $queue,
            $this->getClassicRules(),
            $this->getGameScore($queue),
            $rounds,
        );
    }
    
    public function getGame(GameData $gameData): Game
    {
        return new Game(
            new RoundInitialHandler($this->getEventManager(), $this->getDiceDistributor()),
            new RoundInProgressHandler($this->getEventManager()),
            new RoundCompleteHandler($this->getEventManager(), $this),
            $this,
            $gameData,
        );
    }
}
