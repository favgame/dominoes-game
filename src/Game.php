<?php

namespace Dominoes;

use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\Ga\DiceListFactory;
use Dominoes\GameRounds\Round;
use Dominoes\Players\PlayerInterface;

final class Game
{
    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @var GameData
     */
    private GameData $gameData;

    /**
     * @param GameData $gameData
     */
    public function __construct(GameData $gameData)
    {
        $this->gameData = $gameData;
        $this->eventManager = new EventManager();
        $this->subscribePlayers();
    }

    /**
     * @throws InvalidBindingException
     */
    public function run(): void
    {
        $round = $this->createRound();
        $round->run();
    }

    /**
     * @return void
     */
    private function subscribePlayers(): void
    {
        $players = $this->gameData->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            $this->eventManager->subscribe($player, DiceGivenEvent::EVENT_NAME);
        });
    }

    /**
     * @return Round
     */
    private function createRound(): Round
    {
        $diceList = (new DiceListFactory($this->gameData->getRules()))->createList();
        $roundData = new RoundData(Id::next(), $diceList, $this->gameData->getPlayerList());

        return new Round($roundData, $this->gameData->getRules(), $this->eventManager);
    }
}
