<?php

namespace Dominos/Players;

final class PlayerList
{
    private array $players = [];

    public function addPlayer(PlayerInterface $player): void
    {
        $this->players[] = $player;
    }

    public function getAll(): array
    {
        return $this->players;
    }
}
