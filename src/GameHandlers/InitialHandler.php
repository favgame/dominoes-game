<?php

namespace FavGame\DominoesGame\GameHandlers;

use FavGame\DominoesGame\PlayerCountException;

/**
 * Начальный обработчик
 */
final class InitialHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     * @throws PlayerCountException
     */
    public function handleData(): void
    {
        if ($this->gameData->getStatus()->isDone()) {
            return;
        }

        if ($this->gameData->getStatus()->isInitial()) {
            $this->checkPlayerCount();
        }

        $this->handleNext();
    }

    /**
     * Проверить кол-во игроков на соответствие текущим правилам
     *
     * @return void
     * @throws PlayerCountException
     */
    private function checkPlayerCount(): void
    {
        $rules = $this->gameData->getRules();
        $playerCount = $this->gameData->getPlayerList()->getItems()->count();

        if ($playerCount < $rules->getMinPlayerCount() || $playerCount > $rules->getMaxPlayerCount()) {
            throw new PlayerCountException();
        }
    }
}
