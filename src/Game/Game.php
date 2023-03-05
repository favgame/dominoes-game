<?php

namespace FavGame\DominoesGame\Game;

use FavGame\DominoesGame\Field\GameStep;
use FavGame\DominoesGame\Field\GameStepList;
use FavGame\DominoesGame\Game\Handler\RoundHandlerInterface;
use FavGame\DominoesGame\Player\Player;
use FavGame\DominoesGame\Round\InvalidPlayerException;
use FavGame\DominoesGame\Round\InvalidStateException;
use FavGame\DominoesGame\Round\Round;
use FavGame\DominoesGame\Round\RoundFactoryInterface;
use LogicException;

class Game extends GameData
{
    public function __construct(
        private RoundHandlerInterface $initialHandler,
        private RoundHandlerInterface $inProgressHandler,
        private RoundHandlerInterface $completeHandler,
        RoundFactoryInterface $roundFactory,
        GameData $data,
    ) {
        parent::__construct($data->queue, $data->rules, $data->score, $data->rounds);
        
        if ($this->rounds->isEmpty()) {
            $round = $roundFactory->createRound($this->getQueue());
            $this->rounds->addRound($round);
        }
        
        $this->initialHandler->setNext($this->inProgressHandler);
        $this->inProgressHandler->setNext($this->completeHandler);
        $this->completeHandler->setNext($this->initialHandler);
    }
    
    /**
     * @throws LogicException
     */
    public function beginGame(): void
    {
        $this->initialHandler->handle($this, $this->getRound());
    }
    
    /**
     * @throws InvalidStateException
     * @throws InvalidPlayerException
     * @throws LogicException
     */
    public function takeStep(GameStep $step): void
    {
        $this->getRound()->takeStep($this->queue, $step);
        $this->beginGame();
    }
    
    /**
     * @throws InvalidStateException
     * @throws InvalidPlayerException
     * @throws LogicException
     */
    public function giveDice(Player $player): bool
    {
        if ($this->getRound()->giveDice($this->queue, $player)) {
            $this->beginGame();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * @throws InvalidStateException
     * @throws InvalidPlayerException
     */
    public function getSteps(Player $player): GameStepList
    {
        return $this->getRound()->getSteps($this->queue, $player);
    }
    
    /**
     * @throws InvalidStateException
     */
    private function getRound(): Round
    {
        return $this->getRounds()->getCurrent();
    }
}
