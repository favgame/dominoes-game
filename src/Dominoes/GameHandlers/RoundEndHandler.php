<?php

namespace Dominoes\GameHandlers;

use DateTimeImmutable;
use Dominoes\Events\GameEndEvent;
use Dominoes\Events\RoundEndEvent;
use Dominoes\Id;
use Dominoes\PlayerScores\ScoreList;

final class RoundEndHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        $scoreList = new ScoreList($this->gameData->getPlayerList());
        $scoreList->updateScore($this->gameData->getDiceList());
        $leaderScore = $scoreList->getLeaderItem();
        $this->gameData->getScoreList()->updateScore($this->gameData->getDiceList());

        $this->eventManager->addEvent(
            new RoundEndEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $scoreList)
        );

        $this->gameData->setActivePlayer($leaderScore ? $leaderScore->getPlayer() : null);
        $this->gameData->getState()->setReady();

        if ($this->isGameEnd()) {
            $this->eventManager->addEvent(
                new GameEndEvent(Id::next(), new DateTimeImmutable(), $this->gameData)
            );

            $this->gameData->getState()->setDone();

            return;
        }

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
