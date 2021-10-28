<?php

namespace FavGame\Dominoes\PlayerScores;

use ArrayObject;
use FavGame\Dominoes\AbstractList;
use FavGame\Dominoes\Dices\Dice;
use FavGame\Dominoes\Dices\DiceList;
use FavGame\Dominoes\Players\PlayerInterface;
use FavGame\Dominoes\Players\PlayerList;

/**
 * Список игровых очков
 *
 * @method ArrayObject|Score[] getItems()
 */
final class ScoreList extends AbstractList
{
    /**
     * @param PlayerList $playerList Списко игроков
     */
    public function __construct(PlayerList $playerList)
    {
        $items = array_map(fn (PlayerInterface $player) => new Score($player), (array) $playerList->getItems());

        parent::__construct($items);
    }

    /**
     * Обновить игровые очки
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
     * Получить игровые очки конкретного игрока
     *
     * @param PlayerInterface $owner Игрок
     * @return Score Возвращает игровые очки
     * @deprecated
     */
    public function getItemByOwner(PlayerInterface $owner): Score
    {
        $callback = fn (PlayerInterface $player) => ($player === $owner);

        return $this->filterItems($callback)->getIterator()->current();
    }
}