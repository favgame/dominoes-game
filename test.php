<?php

namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use Dominoes\Bots\MelissaBot;
use Dominoes\Bots\SusannaBot;
use Dominoes\GameFactory;
use Dominoes\GameRules\ClassicRules;
use Dominoes\Id;

$game = (new GameFactory)->createGame(new ClassicRules(), new MelissaBot(Id::next()), new SusannaBot(Id::next()));

while ($game->run()) {

}
