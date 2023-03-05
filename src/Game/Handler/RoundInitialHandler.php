<?php

namespace FavGame\DominoesGame\Game\Handler;

use FavGame\DominoesGame\Collection\EmptyCollectionException;
use FavGame\DominoesGame\Dice\DiceDistributor;
use FavGame\DominoesGame\Dice\DiceList;
use FavGame\DominoesGame\Event\EventManager;
use FavGame\DominoesGame\Field\GameField;
use FavGame\DominoesGame\Game\GameData;
use FavGame\DominoesGame\Player\PlayerQueue;
use FavGame\DominoesGame\Round\RoundData;

class RoundInitialHandler extends AbstractRoundHandler
{
    public function __construct(
        private EventManager $eventManager,
        private DiceDistributor $diceDistributor,
    ) {
    }
    
    /**
     * @throws EmptyCollectionException
     */
    public function handle(GameData $game, RoundData $round): void
    {
        if ($round->getState()->isInitial()) {
            if ($game->getRounds()->count() === 1) {
                $this->eventManager->dispatchGameBeginEvent();
            }
            
            $this->eventManager->dispatchRoundStartEvent();
            $this->diceDistributor->distributeDices($round->getDiceList(), $game->getQueue(), $game->getRules());
            $this->changePlayer($game->getQueue(), $round->getDiceList(), $round->getField());
            $round->setInProgress();
        }
        
        $this->handleNext($game, $round);
    }
    
    /**
     * @throws EmptyCollectionException
     */
    private function changePlayer(PlayerQueue $queue, DiceList $diceList, GameField $field): void
    {
        $dices = $diceList->inHands();
        $steps = $field->getAvailableSteps($dices);
        $player = $steps->getStepWithMaxPoints()->getDice()->getOwner();
        $queue->switchTo($player);
    }
}
