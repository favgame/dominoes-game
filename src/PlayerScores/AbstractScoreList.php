<?php

namespace FavGame\DominoesGame\PlayerScores;

use ArrayObject;
use FavGame\DominoesGame\AbstractList;
use FavGame\DominoesGame\Players\PlayerInterface;
use FavGame\DominoesGame\Players\PlayerList;

/**
 * Список игровых очков
 *
 * @method ArrayObject|Score[] getItems()
 */
abstract class AbstractScoreList extends AbstractList
{
    /**
     * @param PlayerList $playerList
     * @return static
     */
    public static function createInstance(PlayerList $playerList): self
    {
        $items = array_map(fn (PlayerInterface $player) => new Score($player), (array) $playerList->getItems());

        return new static($items);
    }

    /**
     * Получить игровые очки конкретного игрока
     *
     * @param PlayerInterface $owner Игрок
     * @return Score Возвращает игровые очки
     */
    public function getItemByOwner(PlayerInterface $owner): Score
    {
        $callback = fn (Score $score) => ($score->getPlayer() === $owner);

        return $this->filterItems($callback)->getIterator()->current();
    }

    /**
     * Получить лидирующий счёт
     *
     * @return Score|null
     */
    abstract public function getLeaderItem(): ?Score;
}
