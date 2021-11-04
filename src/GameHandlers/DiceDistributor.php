<?php

namespace FavGame\DominoesGame\GameHandlers;

use DateTimeImmutable;
use FavGame\DominoesGame\Dices\DiceList;
use FavGame\DominoesGame\Events\DiceGivenEvent;
use FavGame\DominoesGame\Events\EventManager;
use FavGame\DominoesGame\GameData;
use FavGame\DominoesGame\GameField\CellList;
use FavGame\DominoesGame\Id;
use FavGame\DominoesGame\Players\PlayerInterface;

/**
 * Распределитель игральных костей
 */
final class DiceDistributor
{
    /**
     * @var GameData Игровые данные
     */
    private GameData $gameData;

    /**
     * @var EventManager Менеджер событий
     */
    private EventManager $eventManager;

    /**
     * @param EventManager $eventManager Менеджер событий
     * @param GameData $gameData Игровые данные
     */
    public function __construct(EventManager $eventManager, GameData $gameData)
    {
        $this->eventManager = $eventManager;
        $this->gameData = $gameData;
    }

    /**
     * Выдать игральную кость игроку
     *
     * @param PlayerInterface $player Получатель игральной кости
     * @return bool Вернуть TRUE, если игральная кость выдана игроку, иначе FALSE
     */
    public function distributeDice(PlayerInterface $player): bool
    {
        $dice = $this->gameData->getDiceList()->getFreeItem();

        if ($dice) {
            $dice->setOwner($player);
            $this->eventManager->addEvent(
                new DiceGivenEvent(Id::next(), new DateTimeImmutable(), $this->gameData, $dice)
            );

            return true;
        }

        return false;
    }

    /**
     * Раздать игральные кости игрокам
     *
     * @return void
     */
    public function distributeDices(): void
    {
        $diceList = DiceList::createInstance($this->gameData->getRules());
        $cellList = new CellList();
        $this->gameData->setDiceList($diceList);
        $this->gameData->setCellList($cellList);
        $this->gameData->getPlayerList()->eachItems(function (PlayerInterface $player): void {
            for ($count = 0; $count < $this->gameData->getRules()->getInitialDiceCount(); $count++) {
                $this->distributeDice($player);
            }
        });
    }
}
