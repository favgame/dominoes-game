<?php

namespace FavGame\Dominoes\PlayerScores;

use ArrayObject;
use FavGame\Dominoes\AbstractList;
use FavGame\Dominoes\Id;
use FavGame\Dominoes\Players\PlayerInterface;
use FavGame\Dominoes\Players\PlayerList;

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
        $items = array_map(function (PlayerInterface $player): Score {
            return new Score(Id::next(), $player);
        }, (array) $playerList->getItems());

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
