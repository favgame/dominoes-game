<?php

namespace FavGame\DominoesGame;

use FavGame\DominoesGame\Events\EventManager;
use FavGame\DominoesGame\GameField\InvalidAllocationException;
use FavGame\DominoesGame\GameHandlers\GameStepHandler;
use FavGame\DominoesGame\GameHandlers\HandlerInterface;
use FavGame\DominoesGame\GameHandlers\InitialHandler;
use FavGame\DominoesGame\GameHandlers\PlayerCountException;
use FavGame\DominoesGame\GameHandlers\RoundEndHandler;
use FavGame\DominoesGame\GameHandlers\RoundStartHandler;

/**
 * Основной класс
 */
final class Game
{
    /**
     * @var EventManager Менеджер событий
     */
    private EventManager $eventManager;

    /**
     * @var HandlerInterface Нальный обработчик в цепочке обязанностей
     */
    private HandlerInterface $initialHandler;

    /**
     * @param GameData $gameData Игровые данные
     */
    public function __construct(GameData $gameData)
    {
        $this->eventManager = new EventManager();

        $this->initialHandler = new InitialHandler($this->eventManager, $gameData);
        $roundStartHandler = new RoundStartHandler($this->eventManager, $gameData);
        $stepHandler = new GameStepHandler($this->eventManager, $gameData);
        $roundEndHandler = new RoundEndHandler($this->eventManager, $gameData);

        $this->initialHandler->setNextHandler($roundStartHandler);
        $roundStartHandler->setNextHandler($stepHandler);
        $stepHandler->setNextHandler($roundEndHandler);
        $roundEndHandler->setNextHandler($this->initialHandler);
    }

    /**
     * Выполнить доступные итерации игры
     *
     * @return void
     * @throws PlayerCountException
     * @throws InvalidAllocationException
     */
    public function run(): void
    {
        $this->initialHandler->handleData(); // Запустить цепочку обязанностей
        $this->eventManager->fireEvents(); // Отправить события подписчикам
    }

    /**
     * Получить менеджер событий
     *
     * @return EventManager
     */
    public function getEventManager(): EventManager
    {
        return $this->eventManager;
    }
}
