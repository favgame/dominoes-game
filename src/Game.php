<?php

namespace Dominoes;

use Dominoes\Dices\Dice;
use Dominoes\Dices\DiceStepException;
use Dominoes\Dices\DiceStepListFactory;
use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\Events\PlayerChangeEvent;
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
     * @param GameData $data
     */
    public function __construct(GameData $data)
    {
        $this->gameData = $data;
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
     * @throws DiceStepException
     * @throws InvalidBindingException
     */
    private function doPlayerStep(): bool
    {
        $player = $this->gameData->getActivePlayer();
        $diceCount = $this->gameData->getDiceList()->getItemsByOwner($player)->count();

        if ($diceCount == 0) {
            throw new DiceStepException(DiceStepException::OUT_OF_DICE); // Конец игры
        }

        $stepList = (new DiceStepListFactory($this->gameData->getDiceList()))->createList($player);

        if ($stepList->getItems()->count() == 0) {
            throw new DiceStepException(DiceStepException::NO_DICE_TO_STEP); // Поход на базар
        }

        $step = $player->doStep($stepList);

        if ($step) {
            $step->getChosenDice()->setBinding($step->getDestinationDice());

            return true;
        }

        return false;
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
     * @return void
     */
    private function distributeDices(): void
    {
        $players = $this->gameData->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            for ($count = 0; $count < $this->gameData->getRules()->getInitialDiceCount(); $count++) {
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
        $dice = $this->gameData->getDiceList()->getFreeItem();
        $dice->setOwner($player);
        $this->eventManager->addEvent(new DiceGivenEvent(Id::next(), $this->gameData, $dice));
    }

    /**
     * @return void
     */
    private function selectActivePlayer(): void
    {
        $items = $this->gameData->getDiceList()->getItems();
        $maxPointAmount = 0;

        array_walk($items, function (Dice $item) use (&$maxPointAmount): void {
            if ($item->hasOwner() && $item->getPointAmount() >= $maxPointAmount) {
                $maxPointAmount = $item->getPointAmount();
                $this->gameData->setActivePlayer($item->getOwner());
                $this->eventManager->addEvent(new PlayerChangeEvent(Id::next(), $this->gameData, $item->getOwner()));
            }
        });
    }
}
