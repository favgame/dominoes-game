<?php

namespace FavGame\DominoesGame\GameHandlers;

use FavGame\DominoesGame\Events\GameEndEvent;
use FavGame\DominoesGame\Events\RoundEndEvent;
use FavGame\DominoesGame\PlayerScores\RoundScoreList;

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
        $gameScoreList = $this->gameData->getScoreList();
        $roundScoreList = RoundScoreList::createInstance($this->gameData->getPlayerList());
        $roundScoreList->updateScore($this->gameData->getDiceList());
        $leaderScore = $roundScoreList->getLeaderItem();
        $gameScoreList->updateScore($roundScoreList); // Кол-во очков в игре

        $this->eventManager->addEvent(new RoundEndEvent($roundScoreList));

        // Выбор игрока, который начнёт следующий раунд
        $this->gameData->setCurrentPlayer($leaderScore ? $leaderScore->getPlayer() : null);
        $this->gameData->getStatus()->setReady();

        if ($this->isGameEnd()) { // Игра окончена
            $this->eventManager->addEvent(new GameEndEvent($gameScoreList));
            $this->gameData->getStatus()->setDone();
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
