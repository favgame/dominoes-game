<?php

namespace Dominoes;

use Dominoes\Dices\Dice;
use Dominoes\Dices\DiceList;
use Dominoes\Dices\DiceListFactory;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\GameRules\GameRulesInterface;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerList;

final class Game
{
    /**
     * @var GameRulesInterface
     */
    private GameRulesInterface $rules;

    /**
     * @var PlayerList
     */
    private PlayerList $playerList;

    /**
     * @var DiceList
     */
    private DiceList $diceList;

    /**
     * @var PlayerInterface|null
     */
    private ?PlayerInterface $activePlayer;

    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @var GameData
     */
    private GameData $data;

    /**
     * @param GameRulesInterface $rules
     * @param PlayerList $playerList
     */
    public function __construct0(GameRulesInterface $rules, PlayerList $playerList)
    {

    }

    public function __construct(GameData $data)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->playerList = $playerList;
        $this->eventManager = new EventManager();
        $this->diceList = (new DiceListFactory())->createDiceList($this->rules->getMaxSideValue());

        $this->subscribePlayers();
        $this->distributeDices();
        $this->selectActivePlayer();
    }

    public function run(): void
    {
        $this->eventManager->fireEvents();
    }

    /**
     * @return PlayerList
     */
    public function getPlayerList(): PlayerList
    {
        return $this->playerList;
    }

    /**
     * @return GameRulesInterface
     */
    public function getRules(): GameRulesInterface
    {
        return $this->rules;
    }

    /**
     * @return DiceList
     */
    public function getDiceList(): DiceList
    {
        return $this->diceList;
    }

    /**
     * @return PlayerInterface
     */
    private function getActivePlayer(): PlayerInterface
    {
        return $this->activePlayer;
    }

    /**
     * @return void
     */
    private function subscribePlayers(): void
    {
        $players = $this->playerList->getItems();

        array_walk($players, function (PlayerInterface $player) {
            $this->eventManager->subscribe($player, DiceGivenEvent::EVENT_NAME);
        });
    }

    /**
     * @return void
     */
    private function distributeDices(): void
    {
        $players = $this->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            for ($count = 0; $count < $this->getRules()->getInitialDiceCount(); $count++) {
                $dice = $this->getDiceList()->getFreeItem();
                $dice->setOwner($player);
                $this->eventManager->addEvent(new DiceGivenEvent(Id::next(), $dice));
            }
        });
    }

    /**
     * @return void
     */
    private function selectActivePlayer(): void
    {
        $items = $this->getDiceList()->getItems();
        $maxPointAmount = 0;

        array_walk($items, function (Dice $item) use (&$maxPointAmount): void {
            if ($item->hasOwner() && $item->getPointAmount() >= $maxPointAmount) {
                $maxPointAmount = $item->getPointAmount();
                $this->activePlayer = $item->getOwner();
            }
        });
    }
}
