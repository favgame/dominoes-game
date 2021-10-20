<?php

namespace Dominoes\GameRounds;

use Dominoes\Dices\Dice;
use Dominoes\Dices\InvalidBindingException;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\Events\GameStepEvent;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\Events\RoundEndEvent;
use Dominoes\GameRules\RulesInterface;
use Dominoes\GameSteps\StepListFactory;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;
use Dominoes\Players\ScoreList;
use Dominoes\RoundData;

final class Round
{
    /**
     * @var EventManager
     */
    private EventManager $eventManager;

    /**
     * @var RoundData
     */
    private RoundData $roundData;

    /**
     * @var RulesInterface
     */
    private RulesInterface $gameRules;

    /**
     * @var StepListFactory
     */
    private StepListFactory $stepListFactory;

    /**
     * @var PlayerQueue
     */
    private PlayerQueue $playerQueue;

    /**
     * @param RoundData $roundData
     * @param RulesInterface $gameRules
     * @param EventManager $eventManager
     */
    public function __construct(RoundData $roundData, RulesInterface $gameRules, EventManager $eventManager)
    {
        $this->roundData = $roundData;
        $this->gameRules = $gameRules;
        $this->eventManager = $eventManager;
        $this->playerQueue = new PlayerQueue($this->roundData->getPlayerList());
        $this->stepListFactory = new StepListFactory($this->roundData->getDiceList());

        $this->subscribePlayers();
        $this->distributeDices();

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
            $event = new RoundEndEvent(Id::next(), $this->roundData, ScoreList::createList($this->roundData));
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
        if ($this->roundData->getDiceList()->getFreeItem() !== null) { // На базаре есть кости
            return true;
        }

        foreach ($this->roundData->getPlayerList()->getItems() as $player) {
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
        $diceCount = $this->roundData->getDiceList()->getItemsByOwner($player)->count(); // Кол-во костей на руках

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
            $this->eventManager->addEvent(new GameStepEvent(Id::next(), $this->roundData, $step));

            return true; // Ход окончен
        }

        return false;
    }

    /**
     * @return void
     */
    private function subscribePlayers(): void
    {
        $players = $this->roundData->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            $this->eventManager->subscribe($player, DiceGivenEvent::EVENT_NAME);
        });
    }

    /**
     * @return void
     */
    private function distributeDices(): void
    {
        $players = $this->roundData->getPlayerList()->getItems();

        array_walk($players, function (PlayerInterface $player) {
            for ($count = 0; $count < $this->gameRules->getInitialDiceCount(); $count++) {
                $this->distributeDice($player);
            }
        });
    }

    /**
     * @param PlayerInterface $player
     * @return bool
     */
    public function distributeDice(PlayerInterface $player): bool
    {
        $dice = $this->roundData->getDiceList()->getFreeItem();

        if ($dice) {
            $dice->setOwner($player);
            $this->eventManager->addEvent(new DiceGivenEvent(Id::next(), $this->roundData, $dice));

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

        $event = new PlayerChangeEvent(Id::next(), $this->roundData, $this->playerQueue->current());
        $this->eventManager->addEvent($event);
    }
}
