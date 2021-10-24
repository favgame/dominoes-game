<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\GameEndEvent;
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
        $scoreList = new ScoreList($this->gameData->getPlayerList());
        $scoreList->updateScore($this->gameData->getDiceList());

        $this->gameData->getScoreList()->updateScore($this->gameData->getDiceList());
        $event = new RoundEndEvent(Id::next(), $this->gameData, $scoreList);
        $this->eventManager->addEvent($event);

        if ($this->isGameEnd()) {
            $this->eventManager->addEvent(new GameEndEvent(Id::next(), $this->gameData));
            $this->gameData->getState()->setDone();

            return;
        }

        $this->gameData->getState()->setReady();
        $this->handleNext();
    }

    /**
     * @return bool
     */
    private function isGameEnd(): bool
    {
        $leader = $this->gameData->getScoreList()->getLeaderItem();

        if ($leader && $leader->getPointAmount() < $this->gameData->getRules()->getMaxPointAmount()) {
            return false;
        }

        return true;
    }
}
