<?php

namespace FavGame\DominoesGame\Tests\GameField;

use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceSide;
use FavGame\DominoesGame\GameField\Cell;
use FavGame\DominoesGame\GameField\InvalidAllocationException;
use FavGame\DominoesGame\Id;
use PHPUnit\Framework\TestCase;

final class CellTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanSetRightDice(): void
    {
        $leftDice = new Dice(Id::next(), new DiceSide(0), new DiceSide(1));
        $cell = new Cell(Id::next(), $leftDice, $leftDice->getSideA());
        $this->assertFalse($cell->canSetRightDice($leftDice));

        $rightDice = new Dice(Id::next(), new DiceSide(0), new DiceSide(2));
        $this->assertTrue($cell->canSetRightDice($rightDice));

        $invalidDice = new Dice(Id::next(), new DiceSide(1), new DiceSide(1));
        $this->assertFalse($cell->canSetRightDice($invalidDice));
    }

    /**
     * @return void
     */
    public function testInvalidAllocationException(): void
    {
        $leftDice = new Dice(Id::next(), new DiceSide(0), new DiceSide(0));
        $rightDice = new Dice(Id::next(), new DiceSide(1), new DiceSide(1));
        $cell = new Cell(Id::next(), $leftDice, $leftDice->getSideA());
        $this->expectException(InvalidAllocationException::class);
        $cell->setRightDice($rightDice);
    }
}
