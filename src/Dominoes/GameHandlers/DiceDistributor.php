<?php

namespace Dominoes\GameHandlers;

use DateTimeImmutable;
use Dominoes\Dices\DiceList;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventManager;
use Dominoes\GameData;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

/**
 * Класс распределителя игральных костей
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
     * @param PlayerInterface $player Игрок - получатель игральной кости
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
        $this->gameData->setDiceList(new DiceList($this->gameData->getRules()));
        $this->gameData->getPlayerList()->eachItems(function (PlayerInterface $player): void {
            for ($count = 0; $count < $this->gameData->getRules()->getInitialDiceCount(); $count++) {
                $this->distributeDice($player);
            }
        });
    }
}