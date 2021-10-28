<?php

namespace Dominoes\GameHandlers;

use DateTimeImmutable;
use Dominoes\Events\GameEndEvent;
use Dominoes\Events\RoundEndEvent;
use Dominoes\Id;
use Dominoes\PlayerScores\ScoreList;

/**
 * Класс обработчика окончания игрового раунда
 */
final class RoundEndHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        $scoreList = new ScoreList($this->gameData->getPlayerList());
        $scoreList->updateScore($this->gameData->getDiceList()); // Количество очков в раунде
        $leaderScore = $scoreList->getLeaderItem();
        $this->gameData->getScoreList()->updateScore($this->gameData->getDiceList()); // Кол-во очков в игре

        $this->eventManager->addEvent(
            new RoundEndEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $scoreList)
        );

        // Выбор игрока, который начнёт следующий раунд
        $this->gameData->setActivePlayer($leaderScore ? $leaderScore->getPlayer() : null);
        $this->gameData->getState()->setReady();

        if ($this->isGameEnd()) { // Игра окончена
            $this->eventManager->addEvent(
                new GameEndEvent(Id::next(), new DateTimeImmutable(), $this->gameData)
            );

            $this->gameData->getState()->setDone();

            return;
        }

        $this->handleNext();
    }

    /**
     * Определить, закончилась ли игра
     *
     * @return bool Возвращает TRUE, если игрок, иначе FALSE
     */
    private function isGameEnd(): bool
    {
        $leader = $this->gameData->getScoreList()->getLeaderItem();

        if (!$leader || $leader->getPointAmount() < $this->gameData->getRules()->getMaxPointAmount()) {
            return false;
        }

        return true;
    }
}
