<?php

namespace FavGame\DominoesGame\PlayerScores;

use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceList;

/**
 * Список штрафных очков
 */
final class RoundScoreList extends AbstractScoreList
{
    /**
     * Получить счёт очков лидирующего игрока
     *
     * @return Score|null Возвращает счёт очков лидирующего игрока
     */
    public function getLeaderItem(): ?Score
    {
        $points = array_map(fn (Score $playerScore) => $playerScore->getPointAmount(), $this->items);
        $index = array_keys($points, min($points), true);

        if (count($index) !== 1) {
            return null;
        }

        return $this->getItems()[$index[0]];
    }

    /**
     * Обновить штрафные очки
     *
     * @param DiceList $diceList Список игральных костей
     * @return void
     */
    public function updateScore(DiceList $diceList): void
    {
        $this->eachItems(function (Score $item) use ($diceList): void {
            $dices = $diceList->getItemsByOwner($item->getPlayer());
            $points = array_map(fn (Dice $dice) => $dice->getPointAmount(), (array) $dices);
            $item->setPointAmount($item->getPointAmount() + array_sum($points));
        });
    }
}
