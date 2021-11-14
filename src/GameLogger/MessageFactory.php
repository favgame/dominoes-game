<?php

namespace FavGame\DominoesGame\GameLogger;

use FavGame\DominoesGame\Events\DiceGivenEvent;
use FavGame\DominoesGame\Events\EventInterface;
use FavGame\DominoesGame\Events\GameEndEvent;
use FavGame\DominoesGame\Events\GameStartEvent;
use FavGame\DominoesGame\Events\GameStepEvent;
use FavGame\DominoesGame\Events\PlayerChangeEvent;
use FavGame\DominoesGame\Events\RoundEndEvent;
use FavGame\DominoesGame\Events\RoundStartEvent;
use FavGame\DominoesGame\Players\PlayerInterface;
use RuntimeException;

final class MessageFactory implements MessageFactoryInterface
{
    /** @var string Формат даты и времени по умолчанию */
    private const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string Формат даты и времени
     */
    private string $datetimeFormat;

    /**
     * @param string $datetimeFormat Формат даты и времени
     */
    public function __construct(string $datetimeFormat = self::DEFAULT_DATETIME_FORMAT)
    {
        $this->datetimeFormat = $datetimeFormat;
    }

    /**
     * @inheritDoc
     */
    public function createMessage(EventInterface $event): string
    {
        switch (true):
            case $event instanceof GameStartEvent:
                return $this->createGameStartMessage($event);
            case $event instanceof RoundStartEvent:
                return $this->createRoundStartMessage($event);
            case $event instanceof GameEndEvent:
                return $this->createGameEndMessage($event);
            case $event instanceof RoundEndEvent:
                return $this->createRoundEndMessage($event);
            case $event instanceof PlayerChangeEvent:
                return $this->createPlayerChangeMessage($event);
            case $event instanceof DiceGivenEvent:
                return $this->createDiceGivenMessage($event);
            case $event instanceof GameStepEvent:
                return $this->createGameStepMessage($event);
            default:
                throw new RuntimeException(sprintf('Unknown event: %s', $event->getName()));
        endswitch;
    }

    /**
     * @param GameStartEvent $event
     * @return string
     */
    private function createGameStartMessage(GameStartEvent $event): string
    {
        $callback = fn (PlayerInterface $player) => sprintf('"%s"', $player->getName());
        $playerNames = array_map($callback, (array) $event->getPlayerList()->getItems());

        return sprintf(
            '[%s] %s event. Game players: %s',
            $event->getCreatedAt()->format($this->datetimeFormat),
            $event->getName(),
            implode(', ', $playerNames)
        );
    }

    /**
     * @param RoundStartEvent $event
     * @return string
     */
    private function createRoundStartMessage(RoundStartEvent $event): string
    {
        return sprintf(
            '[%s] %s event',
            $event->getCreatedAt()->format($this->datetimeFormat),
            $event->getName()
        );
    }

    /**
     * @param RoundEndEvent $event
     * @return string
     */
    private function createRoundEndMessage(RoundEndEvent $event): string
    {
        $leaderScore = $event->getScoreList()->getLeaderItem();

        if ($leaderScore) {
            return sprintf(
                '[%s] %s event. Player "%s" won',
                $event->getCreatedAt()->format($this->datetimeFormat),
                $event->getName(),
                $leaderScore->getPlayer()->getName()
            );
        }

        return sprintf(
            '[%s] %s event. Round draw',
            $event->getCreatedAt()->format($this->datetimeFormat),
            $event->getName()
        );
    }

    /**
     * @param GameEndEvent $event
     * @return string
     */
    private function createGameEndMessage(GameEndEvent $event): string
    {
        return sprintf(
            '[%s] %s event. Player "%s" won',
            $event->getCreatedAt()->format($this->datetimeFormat),
            $event->getName(),
            $event->getScoreList()->getLeaderItem()->getPlayer()->getName()
        );
    }

    /**
     * @param PlayerChangeEvent $event
     * @return string
     */
    private function createPlayerChangeMessage(PlayerChangeEvent $event): string
    {
        return sprintf(
            '[%s] %s event. Player step "%s"',
            $event->getCreatedAt()->format($this->datetimeFormat),
            $event->getName(),
            $event->getPlayer()->getName()
        );
    }

    /**
     * @param GameStepEvent $event
     * @return string
     */
    private function createGameStepMessage(GameStepEvent $event): string
    {
        if (!$event->getGameStep()->hasDestinationCell()) {
            return sprintf(
                '[%s] %s event. Player "%s" takes a first step: [%d|%d]',
                $event->getCreatedAt()->format($this->datetimeFormat),
                $event->getName(),
                $event->getGameStep()->getChosenDice()->getOwner()->getName(),
                $event->getGameStep()->getChosenDice()->getSideA()->getValue(),
                $event->getGameStep()->getChosenDice()->getSideB()->getValue()
            );
        }

        return sprintf(
            '[%s] %s event. Player "%s" takes a step: [%d|%d] -> [%d|%d]',
            $event->getCreatedAt()->format($this->datetimeFormat),
            $event->getName(),
            $event->getGameStep()->getChosenDice()->getOwner()->getName(),
            $event->getGameStep()->getChosenDice()->getSideA()->getValue(),
            $event->getGameStep()->getChosenDice()->getSideB()->getValue(),
            $event->getGameStep()->getDestinationCell()->getLeftDice()->getSideA()->getValue(),
            $event->getGameStep()->getDestinationCell()->getLeftDice()->getSideB()->getValue(),
        );
    }

    /**
     * @param DiceGivenEvent $event
     * @return string
     */
    private function createDiceGivenMessage(DiceGivenEvent $event): string
    {
        return sprintf(
            '[%s] %s event. Player "%s" given dice: [%d|%d]',
            $event->getCreatedAt()->format($this->datetimeFormat),
            $event->getName(),
            $event->getDice()->getOwner()->getName(),
            $event->getDice()->getSideA()->getValue(),
            $event->getDice()->getSideB()->getValue()
        );
    }
}
