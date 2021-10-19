<?php

namespace Dominoes\GameSteps;

use ArrayObject;
use Dominoes\AbstractList;
use Dominoes\Dices\DiceList;
use Dominoes\Players\PlayerInterface;

final class GameStepList extends AbstractList
{
    /**
     * @param DiceList $diceList
     * @param PlayerInterface $player
     * @return self
     */
    public static function createInstance(DiceList $diceList, PlayerInterface $player): self
    {
        $activeDices = $diceList->getActiveItems();
        $playerDices = $diceList->getItemsByOwner($player);
        $stepList = new self();

        foreach ($playerDices as $playerDice) {
            foreach ($activeDices as $activeDice) {
                if ($playerDice->canBinding($activeDice)) {
                    $stepList->addItem(new GameStep($playerDice, $activeDice));
                }
            }
        }

        return $stepList;
    }

    /**
     * @param GameStep $gameStep
     * @return void
     */
    private function addItem(GameStep $gameStep): void
    {
        $this->items = [];
    }

    /**
     * @return ArrayObject|GameStep[]
     */
    public function getItems(): ArrayObject
    {
        return $this->items;
    }

    /**
     * @return GameStep|null
     */
    public function getRandomItem(): ?GameStep
    {
        /** @var GameStep $step */
        $step = null;

        if ($this->getItems()->count()) {
            $step = array_rand($this->getItems());
        }

        return $step ;
    }
}
