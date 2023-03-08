<?php

namespace FavGame\DominoesGame\Player;

use FavGame\DominoesGame\Collection\Collection;
use FavGame\DominoesGame\Event\EventManager;
use InfiniteIterator;
use InvalidArgumentException;

/**
 * @implements Collection<int, Player>
 */
class PlayerQueue extends Collection
{
    private InfiniteIterator $queue;
    
    /**
     * @inheritDoc
     */
    public function __construct(
        private EventManager $eventManager,
        array $items,
    ) {
        parent::__construct($items);
        $this->initQueue();
    }
    
    /**
     * @throws InvalidArgumentException
     */
    public function addPlayer(Player $player): void
    {
        if ($this->isExists($player)) {
            throw new InvalidArgumentException('Player already added');
        }
        
        $this->items[] = $player;
        $current = $this->getCurrent();
        
        $this->initQueue();
        $this->switchTo($current); // TODO: disable event
    }
    
    /**
     * @throws InvalidArgumentException
     */
    public function switchTo(Player $player): void
    {
        if (!$this->isExists($player)) {
            throw new InvalidArgumentException('Player not in queue');
        }
        
        while ($this->queue->current() !== $player) {
            $this->queue->next();
        }
        
        $this->dispatchEvent();
    }
    
    public function changeNext(): void
    {
        $this->queue->next();
        $this->dispatchEvent();
    }
    
    public function getCurrent(): Player
    {
        return $this->queue->current();
    }
    
    private function isExists(Player $player): bool
    {
        return in_array($player, $this->items);
    }
    
    private function initQueue(): void
    {
        $this->queue = new InfiniteIterator($this->getIterator());
        $this->queue->rewind();
    }
    
    private function dispatchEvent(): void
    {
        $this->eventManager->dispatchPlayerChangeEvent($this->getCurrent());
    }
}
