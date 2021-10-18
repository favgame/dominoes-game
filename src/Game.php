<?php

namespace Dominoes;

use Dominoes\Dices\Dice;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\GameSteps\GameStepManager;
use Dominoes\Players\PlayerInterface;

final class Game
{
    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @var GameStepManager
     */
    private GameStepManager $stepManager;

    /**
     * @var GameData
     */
    private GameData $data;

    /**
     * @param GameData $data
     */
    public function __construct(GameData $data)
    {
        $this->data = $data;
        $this->eventManager = new EventManager();

        $this->subscribePlayers();
        $this->distributeDices();
        $this->selectActivePlayer();
    }

    public function run(): void
    {
        $this->eventManager->fireEvents();
    }

    /**
     * @return void
     */
    private function subscribePlayers(): void
    {
        $players = $this->data->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            $this->eventManager->subscribe($player, DiceGivenEvent::EVENT_NAME);
        });
    }

    /**
     * @return void
     */
    private function distributeDices(): void
    {
        $players = $this->data->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            for ($count = 0; $count < $this->data->getRules()->getInitialDiceCount(); $count++) {
                $this->distributeDice($player);
            }
        });
    }

    /**
     * @param PlayerInterface $player
     * @return void
     */
    public function distributeDice(PlayerInterface $player): void
    {
        $dice = $this->data->getDiceList()->getFreeItem();
        $dice->setOwner($player);
        $this->eventManager->addEvent(new DiceGivenEvent(Id::next(), $this->data, $dice));
    }

    /**
     * @return void
     */
    private function selectActivePlayer(): void
    {
        $items = $this->data->getDiceList()->getItems();
        $maxPointAmount = 0;

        array_walk($items, function (Dice $item) use (&$maxPointAmount): void {
            if ($item->hasOwner() && $item->getPointAmount() >= $maxPointAmount) {
                $maxPointAmount = $item->getPointAmount();
                $this->data->setActivePlayer($item->getOwner());
                $this->eventManager->addEvent(new PlayerChangeEvent(Id::next(), $this->data, $item->getOwner()));
            }
        });
    }
}
