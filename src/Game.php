<?php

namespace Dominoes;

use Dominoes\Dices\DiceList;
use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\Events\GameStepEvent;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\Events\RoundEndEvent;
use Dominoes\GameSteps\StepListFactory;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\PlayerQueue;
use Dominoes\Players\ScoreList;

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
     * @var PlayerQueue
     */
    private PlayerQueue $playerQueue;

    /**
     * @var StepListFactory
     */
    private StepListFactory $stepListFactory;

    /**
     * @param GameData $gameData
     */
    public function __construct(GameData $gameData)
    {
        $this->gameData = $gameData;
        $this->playerQueue = new PlayerQueue($this->gameData->getPlayerList());
        $this->stepListFactory = new StepListFactory($this->gameData->getDiceList());
        $this->eventManager = new EventManager();

        $this->distributeDices();
        $this->subscribePlayers();
    }

    /**
     * @throws InvalidBindingException
     */
    public function run(): void
    {
        $this->eventManager->fireEvents();

        if (!$this->handlePlayerStep()) { // Игрок не закончил ход
            return;
        }

        if ($this->isPlayerWon() || !$this->hasGameSteps()) { // Игра закончена
            $event = new RoundEndEvent(Id::next(), $this->gameData, ScoreList::createList($this->gameData));
            $this->eventManager->addEvent($event);

            return;
        }

        $this->changePlayer();
    }

    /**
     * @return bool
     */
    private function hasGameSteps(): bool
    {
        if ($this->gameData->getDiceList()->getFreeItem() !== null) { // На базаре есть кости
            return true;
        }

        foreach ($this->gameData->getPlayerList()->getItems() as $player) {
            if ($this->stepListFactory->createList($player)->getItems()->count() > 0) { // У игрока есть ход
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isPlayerWon(): bool
    {
        $player = $this->playerQueue->current();
        $diceCount = $this->gameData->getDiceList()->getItemsByOwner($player)->count(); // Кол-во костей на руках

        if ($diceCount == 0) { // У игрока закончились кости
            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @throws InvalidBindingException
     */
    private function handlePlayerStep(): bool
    {
        $player = $this->playerQueue->current(); // Текущий игрок
        $stepList = $this->stepListFactory->createList($player); // Возможные ходы

        if ($stepList->getItems()->count() == 0) { // Поход на базар
            if (!$this->distributeDice($player)) { // На базаре пусто
                return true; // Ход окончен
            }

            return false;
        }

        $step = $player->getStep($stepList); // Ожидание хода игрока

        if ($step) { // Игрок сделал ход
            $step->getChosenDice()->setBinding($step->getDestinationDice());
            $this->eventManager->addEvent(new GameStepEvent(Id::next(), $this->gameData, $step));

            return true; // Ход окончен
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
     * @param DiceList $diceList
     * @return PlayerInterface
     */
    private function getActivePlayer(DiceList $diceList): PlayerInterface
    {
        $activePlayer = null;
        $maxPointAmount = 0;

        foreach ($diceList->getItems() as $item) {
            if ($item->hasOwner() && $item->getPointAmount() >= $maxPointAmount) {
                $maxPointAmount = $item->getPointAmount();
                $activePlayer = $item->getOwner();
            }
        }

        return $activePlayer;
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
     * @return bool
     */
    private function distributeDice(PlayerInterface $player): bool
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
     * @param PlayerInterface|null $player
     */
    private function changePlayer(?PlayerInterface $player = null): void
    {
        if ($player) {
            while ($this->playerQueue->current() !== $player) {
                $this->playerQueue->next();
            }
        }

        $event = new PlayerChangeEvent(Id::next(), $this->gameData, $this->playerQueue->current());
        $this->eventManager->addEvent($event);
    }
}
