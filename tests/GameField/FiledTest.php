<?php

namespace FavGame\DominoesGame\Tests\GameField;

use FavGame\DominoesGame\Bots\MelissaBot;
use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceList;
use FavGame\DominoesGame\Dices\DiceSide;
use FavGame\DominoesGame\GameField\CellList;
use FavGame\DominoesGame\GameField\Field;
use FavGame\DominoesGame\GameField\InvalidStepException;
use FavGame\DominoesGame\GameSteps\Step;
use FavGame\DominoesGame\Id;
use PHPUnit\Framework\TestCase;

final class FiledTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvalidStepException(): void
    {
        $dice = new Dice(Id::next(), new DiceSide(0), new DiceSide(0));
        $dice->setOwner(new MelissaBot(Id::next()));
        $field = new Field(new CellList(), new DiceList());

        $step = new Step($dice, null);
        $this->expectException(InvalidStepException::class);
        $field->applyStep($step);
    }
}
