<?php

namespace FavGame\DominoesGame\Dice;

use FavGame\DominoesGame\Event\EventManager;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Rules\GameRulesInterface;

class DiceDistributor
{
    public function __construct(
        private EventManager $eventManager,
    ) {
    }
    
    public function distributeDices(DiceList $diceList, PlayerQueue $queue, GameRulesInterface $rules): void
    {
        for ($i = 0; $i < $rules->getInitialDiceCount(); $i++) {
            foreach ($queue as $player) {
                $this->distributeDice($diceList, $player);
            }
        }
    }
    
    public function distributeDice(DiceList $diceList, Player $player): bool
    {
        $dices = $diceList->inBank()->getIterator();
        
        if ($dices->count()) {
            $dice = $dices->current();
            $dice->distributeToPlayer($player);
            $this->eventManager->dispatchDiceGivenEvent($dice);
            
            return true;
        }
        
        return false;
    }
}
