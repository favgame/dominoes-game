<?php

namespace Dominoes\Players;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Dices\Dice;
use Dominoes\PlayerScores\Score;
use Dominoes\RoundData;

/**
 * @method ArrayObject|Score[] getItems()
 */
final class ScoreList extends AbstractList
{
    /**
     * @param RoundData $roundData
     * @return static
     */
    public static function createList(RoundData $roundData): self
    {
        $items = [];

        foreach ($roundData->getPlayerList()->getItems() as $player) {
            $dices = $roundData->getDiceList()->getItemsByOwner($player);
            $points = array_map(fn (Dice $dice) => $dice->getPointAmount(), $dices);
            $items[] = new Score($player, array_sum($points));
        }

        return new self($items);
    }

    /**
     * @return Score|null
     */
    public function getWinnerItem(): ?Score
    {
        $points = array_map(fn (Score $playerScore) => $playerScore->getPointAmount(), $this->getItems());
        $index = array_keys($points, min($points), true);

        if (count($index) !== 1) {
            return null;
        }

        return $this->getItems()[$index[0]];
    }
}
