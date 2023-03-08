<?php

namespace FavGame\DominoesGame\Game\Handler;

use FavGame\DominoesGame\Dice\DiceList;
use FavGame\DominoesGame\Event\EventManager;
use FavGame\DominoesGame\Field\GameField;
use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Round\RoundData;

class RoundInProgressHandler implements RoundHandlerInterface
{
    public function __construct(
        private EventManager $eventManager,
    ) {
    }
    
    public function handle(GameData $game, RoundData $round): void
    {
        if ($round->getState()->isInProgress()) {
            $winner = $this->getWinner($game->getQueue(), $round->getDiceList());
            
            if ($winner || $this->isDraw($round->getDiceList(), $round->getField())) {
                $round->getScore()->calculateValues($round->getDiceList(), $winner);
                $round->setComplete();
                $this->eventManager->dispatchRoundFinishEvent($round->getScore());
            } else {
                $this->updateQueue($game->getQueue(), $round->getDiceList(), $round->getField());
            }
        }
    }
    
    private function getWinner(PlayerQueue $queue, DiceList $diceList): Player|null // Есть победитель
    {
        foreach ($queue as $player) {
            if ($diceList->inHands($player)->isEmpty()) { // У игрока закончились кости
                return $player;
            }
        }
        
        return null;
    }
    
    private function isDraw(DiceList $diceList, GameField $field): bool // Ничья
    {
        if ($diceList->isBankEmpty()) { // Базар пустой 
            if (!$field->hasSteps($diceList->inHands())) { // Ходов нет
                return true;
            }
        }
        
        return false;
    }
    
    private function updateQueue(PlayerQueue $queue, DiceList $diceList, GameField $field): void
    {
        if ($diceList->isBankEmpty()) { // Базар пустой
            $player = $queue->getCurrent();
            
            if (!$field->hasSteps($diceList->inHands($player))) {
                $queue->changeNext();
            }
        }
    }
}
