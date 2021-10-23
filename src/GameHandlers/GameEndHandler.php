<?php

namespace Dominoes\GameHandlers;

final class GameEndHandler extends AbstractGameHandler
{
    /**
     * @inheritDoc
     */
    public function handleData(): void
    {
        $this->handleNext();

        $this->gameData->getState()->setValueDone();
    }
}
