<?php

namespace Dominoes\Bots;

use Dominoes\Game;
use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

abstract class AbstractBot implements PlayerInterface
{
    /**
     * @var Id
     */
    private Id $id;

    /***
     * @param Id $id
     */
    public function __construct(Id $id)
    {
        $this->id = $id;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @param Game $game
     */
    public function onGameUpdate(Game $game): void
    {

    }

    public function getGameStep(Game $game): ?GameStep
    {
    }
}
