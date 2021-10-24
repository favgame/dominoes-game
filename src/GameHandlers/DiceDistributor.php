<?php

namespace Dominoes\GameHandlers;

use Dominoes\Dices\DiceList;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\GameData;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

final class DiceDistributor
{
    /**
     * @var GameData
     */
    private GameData $gameData;

    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @param EventManager $eventManager
     * @param GameData $gameData
     */
    public function __construct(EventManager $eventManager, GameData $gameData)
    {
        $this->eventManager = $eventManager;
        $this->gameData = $gameData;
    }

    /**
     * @param PlayerInterface $player
     * @return bool
     */
    public function distributeDice(PlayerInterface $player): bool
    {
        $dice = $this->gameData->getDiceList()->getFreeItem();

        if ($dice) {
            $dice->setOwner($player);
            $this->eventManager->addEvent(new DiceGivenEvent(Id::next(), $this->gameData, $dice));

            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function distributeDices(): void
    {
        $this->gameData->setDiceList(new DiceList($this->gameData->getRules()));
        $this->gameData->getPlayerList()->eachItems(function (PlayerInterface $player): void {
            for ($count = 0; $count < $this->gameData->getRules()->getInitialDiceCount(); $count++) {
                $this->distributeDice($player);
            }
        });
    }
}
