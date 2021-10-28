<?php

namespace FavGame\Dominoes\PlayerScores;

use FavGame\Dominoes\Dices\Dice;
use FavGame\Dominoes\Dices\DiceList;
use FavGame\Dominoes\Players\PlayerList;

/**
 * Список штрафных очков
 */
final class RoundScoreList extends AbstractScoreList
{
    /**
     * @param PlayerList $playerList
     * @param DiceList $diceList
     */
    public function __construct(PlayerList $playerList, DiceList $diceList)
    {
        parent::__construct($playerList);

        $this->updateScore($diceList);
    }

    /**
     * Получить лидирующий счёт
     *
     * @return Score|null
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
     * Обновить игровые очки
     *
     * @param DiceList $diceList Список игральных костей
     * @return void
     */
    private function updateScore(DiceList $diceList): void
    {
        $this->eachItems(function (Score $item) use ($diceList): void {
            $dices = $diceList->getItemsByOwner($item->getPlayer());
            $points = array_map(fn (Dice $dice) => $dice->getPointAmount(), (array) $dices);
            $item->setPointAmount($item->getPointAmount() + array_sum($points));
        });
    }
}
