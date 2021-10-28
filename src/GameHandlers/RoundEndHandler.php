<?php

namespace FavGame\Dominoes\GameHandlers;

use DateTimeImmutable;
use FavGame\Dominoes\Events\GameEndEvent;
use FavGame\Dominoes\Events\RoundEndEvent;
use FavGame\Dominoes\Id;
use FavGame\Dominoes\PlayerScores\RoundScoreList;

/**
 * Обработчик окончания игрового раунда
 */
final class RoundEndHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        $roundScoreList = new RoundScoreList($this->gameData->getPlayerList(), $this->gameData->getDiceList());
        $leaderScore = $roundScoreList->getLeaderItem();
        $this->gameData->getScoreList()->updateScore($roundScoreList); // Кол-во очков в игре

        $this->eventManager->addEvent(
            new RoundEndEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $roundScoreList)
        );

        // Выбор игрока, который начнёт следующий раунд
        $this->gameData->setActivePlayer($leaderScore ? $leaderScore->getPlayer() : null);
        $this->gameData->getStatus()->setReady();

        if ($this->isGameEnd()) { // Игра окончена
            $this->eventManager->addEvent(
                new GameEndEvent(Id::next(), new DateTimeImmutable(), $this->gameData)
            );

            $this->gameData->getStatus()->setDone();

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
