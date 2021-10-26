<?php

namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use Dominoes\Bots\MelissaBot;
use Dominoes\Bots\SusannaBot;
use Dominoes\Events\DiceGivenEvent;
use Dominoes\Events\EventInterface;
use Dominoes\Events\EventListenerInterface;
use Dominoes\Events\GameEndEvent;
use Dominoes\Events\GameStartEvent;
use Dominoes\Events\GameStepEvent;
use Dominoes\Events\PlayerChangeEvent;
use Dominoes\Events\RoundEndEvent;
use Dominoes\Events\RoundStartEvent;
use Dominoes\GameFactory;
use Dominoes\GameRules\ClassicRules;
use Dominoes\Id;
use RuntimeException;

class Logger implements EventListenerInterface
{
    /** @var string */
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string[]
     */
    private array $messages = [];

    /**
     * @inheritDoc
     */
    public function handleEvent(EventInterface $event): void
    {
        $this->messages[] = $event->getCreatedAt()->format(self::DATETIME_FORMAT) . ' ' . $this->createMessage($event);
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param EventInterface $event
     * @return string
     */
    private function createMessage(EventInterface $event): string
    {
        switch (true):
            case $event instanceof GameStartEvent:
            case $event instanceof RoundStartEvent:
                return sprintf('%s event', $event->getName());
            case $event instanceof GameEndEvent:
                return sprintf(
                    '%s event. Player "%s" won',
                    $event->getName(),
                    $event->getGameData()->getScoreList()->getLeaderItem()->getPlayer()->getName()
                );
            case $event instanceof RoundEndEvent:
                $leaderScore = $event->getScoreList()->getLeaderItem();

                if (!$leaderScore) {
                    return sprintf('%s event. Round draw', $event->getName());
                }

                return sprintf('%s event. Player "%s" won', $event->getName(), $leaderScore->getPlayer()->getName());
            case $event instanceof PlayerChangeEvent:
                return sprintf('%s event. Player step "%s"', $event->getName(), $event->getPlayer()->getName());
            case $event instanceof DiceGivenEvent:
                return sprintf(
                    '%s event. Player "%s" given dice: [%d|%d]',
                    $event->getName(), $event->getDice()->getOwner()->getName(),
                    $event->getDice()->getSideA()->getValue(),
                    $event->getDice()->getSideB()->getValue()
                );
            case $event instanceof GameStepEvent:
                return sprintf(
                    '%s event. Player "%s" takes a step: [%d|%d] -> [%d|%d]',
                    $event->getName(), $event->getGameStep()->getChosenDice()->getOwner()->getName(),
                    $event->getGameStep()->getChosenDice()->getSideA()->getValue(),
                    $event->getGameStep()->getChosenDice()->getSideB()->getValue(),
                    $event->getGameStep()->getDestinationDice()->getSideA()->getValue(),
                    $event->getGameStep()->getDestinationDice()->getSideB()->getValue(),
                );
            default:
                throw new RuntimeException(sprintf('Unknown event: %s', $event->getName()));
        endswitch;
    }
}

$inWork = true;
$logger = new Logger();
$game = (new GameFactory)->createGame(new ClassicRules(), new MelissaBot(Id::next()), new SusannaBot(Id::next()));
$game->getEventManager()->subscribe($logger);

while ($inWork) {
    $inWork = $game->run();
    $messages = $logger->getMessages();

    if ($messages) {
        $content = implode(PHP_EOL, $messages);
        file_put_contents('./game_log.txt', $content);
    }
}
