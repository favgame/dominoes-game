<?php

namespace FavGame\DominoesGame\GameHandlers;

use FavGame\DominoesGame\Events\GameStepEvent;
use FavGame\DominoesGame\Events\PlayerChangeEvent;
use FavGame\DominoesGame\GameField\Field;
use FavGame\DominoesGame\GameField\InvalidAllocationException;
use FavGame\DominoesGame\GameField\InvalidStepException;
use InfiniteIterator;

/**
 * Обработчик ходов игроков
 */
final class GameStepHandler extends AbstractGameHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     * @throws InvalidAllocationException
     * @throws InvalidStepException
     */
    public function handleData(): void
    {
        while (true) {
            if ($this->distributeDice()) { // Поход на базар
                continue; // Новая попытка хода
            }

            if (!$this->handlePlayerStep()) { // Игрок не сделал ход
                break; // Прервать обработку ходов
            }

            if ($this->isRoundEnd()) { // Раунд окончен
                $this->handleNext();

                break; // Прервать обработку ходов
            }

            $this->changeNextPlayer(); // Переход хода
        }
    }

    /**
     * Обработать ход игрока
     *
     * @return bool Возвращает TRUE, если игрок сделал ход, иначе FALSE
     * @throws InvalidAllocationException
     * @throws InvalidStepException
     */
    private function handlePlayerStep(): bool
    {
        $player = $this->gameData->getCurrentPlayer();
        $gameField = new Field($this->gameData->getCellList(), $this->gameData->getDiceList());
        $stepList = $gameField->getAvailableSteps($player); // Возможные ходы

        if ($stepList->getItems()->count() == 0) {
            return true; // У игрока нет доступных ходов
        }

        $step = $player->getStep($stepList); // Ожидание хода игрока

        if ($step) { // Игрок сделал ход
            $gameField->applyStep($step); // Положить игральную кость на поле
            $this->eventManager->addEvent(new GameStepEvent($step));

            return true; // Ход окончен
        }

        return false;
    }

    /**
     * Выдать игральную кость игроку
     *
     * @return bool Возвращает TRUE, если игроку была выдана игральная кость, иначе FALSE
     */
    private function distributeDice(): bool
    {
        $player = $this->gameData->getCurrentPlayer();
        $diceDistributor = new DiceDistributor($this->eventManager, $this->gameData);
        $gameField = new Field($this->gameData->getCellList(), $this->gameData->getDiceList());
        $stepList = $gameField->getAvailableSteps($player);

        if ($stepList->getItems()->count() < 1 && $diceDistributor->distributeDice($player)) {
            return true;
        }

        return false;
    }

    /**
     * Определить, закончился ли текущий раунд
     *
     * @return bool Возвращает TRUE, если у игрока не осталось игральных костей, иначе FALSE
     */
    private function isRoundEnd(): bool
    {
        $player = $this->gameData->getCurrentPlayer();
        $diceCount = $this->gameData->getDiceList()->getItemsByOwner($player)->count(); // Кол-во костей на руках
        $gameField = new Field($this->gameData->getCellList(), $this->gameData->getDiceList());

        if ($diceCount == 0 || !$gameField->hasSteps()) { // У игрока закончились кости, либо закончились игровые ходы
            return true;
        }

        return false;
    }

    /**
     * Сменить игрока для следующего хода
     *
     * @return void
     */
    private function changeNextPlayer(): void
    {
        $queue = new InfiniteIterator($this->gameData->getPlayerList()->getItems()->getIterator());
        $player = $this->gameData->getCurrentPlayer();

        if ($player) {
            while ($queue->current() !== $player) { // Перемотать очередь до текущего игрока
                $queue->next();
            }
        }

        $queue->next(); // Сменить очередь на следующего игрока
        $player = $queue->current();

        $this->gameData->setCurrentPlayer($player);
        $this->eventManager->addEvent(new PlayerChangeEvent($player));
    }
}
