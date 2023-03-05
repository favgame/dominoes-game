<?php

namespace FavGame\DominoesGame\Field;

use FavGame\DominoesGame\Collection\Collection;
use FavGame\DominoesGame\Dice\Dice;
use FavGame\DominoesGame\Event\EventManager;
use LogicException;

/**
 * @implements Collection<int, Collision>
 */
class GameField extends Collection
{
    /**
     * @param array<int, Collision> $collisions
     */
    public function __construct(
        private EventManager $eventManager,
        private CollisionFactoryInterface $collisionFactory,
        private GameStepFactoryInterface $container,
        array $collisions,
    ) {
        parent::__construct($collisions);
    }
    
    /**
     * @return static<int, Collision>
     */
    public function getFreeCollision(): static
    {
        return $this->filter(fn (Collision $collision) => !$collision->hasDiceB());
    }
    
    /**
     * @param Dice[] $dices
     */
    public function getAvailableSteps(iterable $dices): GameStepList
    {
        $collisions = $this->getFreeCollision();
        $steps = [];
        
        foreach ($collisions as $collision) {
            foreach ($dices as $dice) {
                if ($collision->canAddCollision($dice)) {
                    $steps[] = $this->container->createGameStep($dice, $collision);
                }
            }
        }
        
        if ($collisions->count() < 1) {
            foreach ($dices as $dice) {
                $steps[] = $this->container->createGameStep($dice, null);
            }
        }
        
        return $this->container->createGameStepList($steps);
    }
    
    /**
     * @param Dice[] $dices
     * @return bool
     */
    public function hasSteps(iterable $dices): bool
    {
        return ($this->getAvailableSteps($dices)->count() > 0);
    }
    
    /**
     * @throws InvalidAllocationException
     * @throws InvalidStepException
     * @throws LogicException
     */
    public function applyStep(GameStep $step): void
    {
        if ($this->isFirstStep() == $step->hasTarget()) {
            throw new InvalidStepException();
        }
        
        if ($this->isFirstStep()) { // Первый ход
            $this->applyFirstStep($step);
        } else {
            $this->applyNextStep($step);
        }
        
        $this->eventManager->dispatchGameStepEvent($step);
    }
    
    /**
     * @throws LogicException
     */
    private function applyFirstStep(GameStep $step): void
    {
        $dice = $step->getDice();
        $dice->putOnField();
        $this->append($this->collisionFactory->createCollision($dice->getSideA(), $dice));
        $this->append($this->collisionFactory->createCollision($dice->getSideB(), $dice));
    }
    
    private function isFirstStep(): bool
    {
        return $this->isEmpty();
    }
    
    /**
     * @param Collision $item
     */
    private function append(mixed $item): void
    {
        $this->items[] = $item;
    }
    
    /**
     * @throws InvalidAllocationException
     * @throws InvalidStepException
     * @throws LogicException
     */
    private function applyNextStep(GameStep $step): void
    {
        $dice = $step->getDice();
        $collisions = $this->getFreeCollision();
        
        foreach ($collisions as $target) {
            if ($target === $step->getTarget() && $target->canAddCollision($dice)) {
                $value = ($dice->getSideA() === $target->getValue()) ? $dice->getSideB() : $dice->getSideA();
                $collision = $this->collisionFactory->createCollision($value, $dice);
                $target->addCollision($dice);
                $dice->putOnField();
                $this->append($collision);
                
                return;
            }
        }
    
        throw new InvalidStepException();
    }
}
