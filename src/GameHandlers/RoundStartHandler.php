<?php

namespace Dominoes\GameHandlers;

use Dominoes\GameData;
use Dominoes\Players\PlayerInterface;

final class RoundStartHandler extends AbstractGameHandler
{
    /**
     * @param GameData $gameData
     * @return void
     */
    public function handleData(GameData $gameData): void
    {
        if ($gameData->getState()->isInitial()) {
            $this->distributeDices();

            $gameData->getState()->setValueInProgress();
        }

        $this->handleNext($gameData);
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
}
