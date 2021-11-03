<?php

namespace FavGame\DominoesGame\PlayerScores;

/**
 * Список игровых очков
 */
final class GameScoreList extends AbstractScoreList
{
    /**
     * Обновить игровые очки
     *
     * @param RoundScoreList $roundScoreList
     * @return void
     */
    public function updateScore(RoundScoreList $roundScoreList): void
    {
        $leaderScore = $roundScoreList->getLeaderItem();

        if ($leaderScore) {
            $score = $this->getItemByOwner($leaderScore->getPlayer());

            $roundScoreList->eachItems(function (Score $item) use ($score): void {
                if ($item->getPlayer() !== $score->getPlayer()) {
                    $score->setPointAmount($score->getPointAmount() + $item->getPointAmount());
                }
            });
        }
    }

    /**
     * Получить лидирующий счёт
     *
     * @return Score|null
     */
    public function getLeaderItem(): ?Score
    {
        $points = array_map(fn (Score $playerScore) => $playerScore->getPointAmount(), $this->items);
        $index = array_keys($points, max($points), true);

        if (count($index) !== 1) {
            return null;
        }

        return $this->getItems()[$index[0]];
    }
}
