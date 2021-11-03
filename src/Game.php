<?php

namespace FavGame\DominoesGame;

use FavGame\DominoesGame\Dices\InvalidBindingException;
use FavGame\DominoesGame\Events\EventManager;
use FavGame\DominoesGame\GameHandlers\GameStepHandler;
use FavGame\DominoesGame\GameHandlers\HandlerInterface;
use FavGame\DominoesGame\GameHandlers\InvalidStepException;
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
     * @var GameData Игровые данные
     */
    private GameData $gameData;

    /**
     * @var HandlerInterface Нальный обработчик в цепочке обязанностей
     */
    private HandlerInterface $mainHandler;

    /**
     * @param GameData $gameData Игровые данные
     */
    public function __construct(GameData $gameData)
    {
        $this->gameData = $gameData;
        $this->eventManager = new EventManager();

        $roundStartHandler = new RoundStartHandler($this->eventManager, $gameData);
        $stepHandler = new GameStepHandler($this->eventManager, $gameData);
        $roundEndHandler = new RoundEndHandler($this->eventManager, $gameData);

        $roundStartHandler->setNextHandler($stepHandler);
        $stepHandler->setNextHandler($roundEndHandler);
        $roundEndHandler->setNextHandler($roundStartHandler);

        $this->mainHandler = $roundStartHandler;
    }

    /**
     * Выполнить одну итерацию игры
     *
     * @return bool
     * @throws PlayerCountException
     * @throws InvalidBindingException
     * @throws InvalidStepException
     */
    public function run(): bool
    {
        $this->checkPlayerCount();
        $this->eventManager->fireEvents(); // Отправить события подписчикам

        if ($this->gameData->getStatus()->isDone()) {
            return false; // Игра окончена
        }

        $this->mainHandler->handleData(); // Запустить цепочку обязанностей

        return true;
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
