<?php

namespace FavGame\DominoesGame\Event;

use FavGame\DominoesGame\Dice\Dice;
use FavGame\DominoesGame\Field\GameStep;
use FavGame\DominoesGame\Game\GameScore;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Round\RoundScore;

class EventManager
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private GameEventFactoryInterface $eventFactory,
    ) {
    }
    
    public function dispatchGameBeginEvent(): void
    {
        $this->dispatchEvent(GameEventType::gameBegin);
    }
    
    public function dispatchGameEndEvent(GameScore $score): void
    {
        $this->dispatchEvent(GameEventType::gameEnd, $score);
    }
    
    public function dispatchRoundStartEvent(): void
    {
        $this->dispatchEvent(GameEventType::roundStart);
    }
    
    public function dispatchRoundFinishEvent(RoundScore $score): void
    {
        $this->dispatchEvent(GameEventType::roundFinish, $score);
    }
    
    public function dispatchPlayerChangeEvent(Player $player): void
    {
        $this->dispatchEvent(GameEventType::playerChange, $player);
    }
    
    public function dispatchDiceGivenEvent(Dice $dice): void
    {
        $this->dispatchEvent(GameEventType::diceGiven, $dice);
    }
    
    public function dispatchGameStepEvent(GameStep $step): void
    {
        $this->dispatchEvent(GameEventType::gameStep, $step);
    }
    
    private function dispatchEvent(GameEventType $type, mixed ...$params): void
    {
        array_unshift($params, $type);
        
        $event = $this->eventFactory->createEvent($type, ...$params);
        $this->eventDispatcher->dispatchEvent($event);
    }
}
