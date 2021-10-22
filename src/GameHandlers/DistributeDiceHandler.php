<?php

namespace Dominoes\GameHandlers;

use Dominoes\Events\DiceGivenEvent;
use Dominoes\GameData;
use Dominoes\GameSteps\StepListFactory;
use Dominoes\Id;

final class DistributeDiceHandler extends AbstractGameHandler implements HandlerInterface
{
    /**
     * @param GameData $gameData
     * @return void
     */
    public function handleData(GameData $gameData): void
    {
        $player = $gameData->getActivePlayer(); // Текущий игрок
        $stepList = (new StepListFactory($gameData->getDiceList()))->createList($player); // Возможные ходы

        if ($stepList->getItems()->count() == 0) { // Поход на базар
            if ($this->distributeDice($gameData)) { // На базаре пусто
                $this->handleNext($gameData);
            }
        }
    }

    /**
     * @param GameData $gameData
     * @return bool
     */
    private function distributeDice(GameData $gameData): bool
    {
        $player = $gameData->getActivePlayer();
        $dice = $gameData->getDiceList()->getFreeItem();

        if ($dice) {
            $dice->setOwner($player);
            $this->eventManager->addEvent(new DiceGivenEvent(Id::next(), $gameData, $dice));

            return true;
        }

        return false;
    }
}
