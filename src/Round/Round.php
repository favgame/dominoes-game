<?php

namespace FavGame\DominoesGame\Round;

use FavGame\DominoesGame\Dice\DiceDistributor;
use FavGame\DominoesGame\Field\GameStep;
use FavGame\DominoesGame\Field\GameStepList;
use FavGame\DominoesGame\Field\InvalidStepException;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Player\PlayerQueue;

class Round extends RoundData
{
    public function __construct(
        private DiceDistributor $diceDistributor,
        RoundData $roundData,
    ) {
        parent::__construct($roundData->diceList, $roundData->score, $roundData->field, $roundData->state);
    }
    
    /**
     * @throws InvalidStateException
     * @throws InvalidPlayerException
     * @throws InvalidStepException
     */
    public function takeStep(PlayerQueue $queue, GameStep $step): void
    {
        $this->checkState();
        $this->checkPlayerQueue($queue, $step->getDice()->getOwner());
        $this->getField()->applyStep($step);
        $queue->changeNext();
    }
    
    /**
     * @throws InvalidStateException
     * @throws InvalidPlayerException
     */
    public function giveDice(PlayerQueue $queue, Player $player): bool
    {
        $this->checkState();
        $this->checkPlayerQueue($queue, $player);
        
        return $this->diceDistributor->distributeDice($this->getDiceList(), $player);
    }
    
    /**
     * @throws InvalidStateException
     * @throws InvalidPlayerException
     */
    public function getSteps(PlayerQueue $queue, Player $player): GameStepList
    {
        $this->checkState();
        $this->checkPlayerQueue($queue, $player);
        
        $dices = $this->getDiceList()->inHands($player);
        
        return $this->getField()->getAvailableSteps($dices);
    }
    
    /**
     * @throws InvalidStateException
     */
    private function checkState(): void
    {
        if (!$this->getState()->isInProgress()) {
            throw new InvalidStateException();
        }
    }
    
    /**
     * @throws InvalidPlayerException
     */
    private function checkPlayerQueue(PlayerQueue $queue, Player|null $player): void
    {
        if ($queue->getCurrent() !== $player) {
            throw new InvalidPlayerException();
        }
    }
}
