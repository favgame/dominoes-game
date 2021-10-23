<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\RoundEndEvent;
use Dominoes\Id;
use Dominoes\Players\ScoreList;

final class RoundEndHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        $event = new RoundEndEvent(Id::next(), $this->gameData, ScoreList::createList($this->gameData));
        $this->eventManager->addEvent($event);

        $this->handleNext();
    }
}
