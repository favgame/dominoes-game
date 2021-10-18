<?php

namespace Dominoes\GameSteps;

use Dominoes\Dices\Dice;
use Dominoes\Dices\InvalidBindingException;
use Dominoes\GameData;
use Dominoes\Players\PlayerInterface;

final class GameStepManager
{
    /**
     * @var GameData
     */
    private GameData $gameData;

    public function __construct(GameData $gameData)
    {
        $this->gameData = $gameData;
    }

    /**
     * @throws GameStepException
     * @throws InvalidBindingException
     */
    public function doPlayerStep(): bool
    {
        $player = $this->gameData->getActivePlayer();
        $diceCount = $this->gameData->getDiceList()->getItemsByOwner($player)->count();

        if ($diceCount == 0) {
            throw new GameStepException(GameStepException::OUT_OF_DICE); // Конец игры
        }

        $stepList = $this->getAvailableSteps($player);

        if ($stepList->getItems()->count() == 0) {
            throw new GameStepException(GameStepException::NO_DICE_TO_STEP); // Поход на базар
        }

        $step = $player->doStep($stepList);

        if ($step) {
            $step->getChosenDice()->setBinding($step->getDestinationDice());

            return true;
        }

        return false;
    }

    private function getAvailableSteps(PlayerInterface $player): GameStepList
    {
        $activeDices = $this->gameData->getDiceList()->getActiveItems();
        $playerDices = $this->gameData->getDiceList()->getItemsByOwner($player);
        $stepList = new GameStepList();

        $dices = array_filter($playerDices, fn (Dice $dice) => !$dice->isUsed() && $playerDices);

        foreach ($playerDices as $playerDice) {
            $stepList->addItem(new GameStep($playerDice));
        }

        return $stepList;
    }
}
