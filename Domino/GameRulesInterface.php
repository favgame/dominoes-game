<?php

namespace Domino;

interface GameRulesInterface
{
   public function getMinPlayers(): int;

   public function getMaxPlayers(): int;
}
