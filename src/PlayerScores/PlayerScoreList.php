<?php

namespace Dominoes\Players;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Dices\Dice;
use Dominoes\GameData;
use Dominoes\PlayerScores\PlayerScore;

/**
 * @method ArrayObject|PlayerScore[] getItems()
 */
final class PlayerScoreList extends AbstractList
{
    /**
     * @param GameData $gameData
     */
    public function __construct(GameData $gameData)
    {
        parent::__construct();

        foreach ($gameData->getPlayerList()->getItems() as $player) {
            $dices = $gameData->getDiceList()->getItemsByOwner($player);
            $points = array_map(fn (Dice $dice) => $dice->getPointAmount(), $dices);
            $this->items[] = new PlayerScore($player, array_sum($points));
        }
    }

    /**
     * @return PlayerScore|null
     */
    public function getWinnerItem(): ?PlayerScore
    {
        $points = array_map(fn (PlayerScore $playerScore) => $playerScore->getPointAmount(), $this->getItems());
        $index = array_keys($points, min($points), true);

        if (count($index) !== 1) {
            return null;
        }

        return $this->getItems()[$index[0]];
    }
}
