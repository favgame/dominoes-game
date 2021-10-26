<?php

namespace Dominoes\PlayerScores;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Dices\Dice;
use Dominoes\Dices\DiceList;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;

/**
 * @method ArrayObject|Score[] getItems()
 */
final class ScoreList extends AbstractList
{
    /**
     * @param PlayerList $playerList
     */
    public function __construct(PlayerList $playerList)
    {
        $items = array_map(fn (PlayerInterface $player) => new Score($player), (array) $playerList->getItems());

        parent::__construct($items);
    }

    /**
     * @param DiceList $diceList
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
     * @param PlayerInterface $owner
     * @return Score|null
     * @deprecated
     */
    public function getItemByOwner(PlayerInterface $owner): ?Score
    {
        $callback = fn (PlayerInterface $player) => ($player === $owner);

        return $this->filterItems($callback)->getIterator()->current();
    }
}
