<?php

namespace FavGame\DominoesGame\Event;

enum GameEventType: string
{
    case gameBegin = 'Game begin';
    case gameEnd = 'Game end';
    case roundStart = 'Round start';
    case roundFinish = 'Round finish';
    case diceGiven = 'Dice given';
    case gameStep = 'Game step';
    case playerChange = 'Player change';
}
