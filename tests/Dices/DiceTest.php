<?php

namespace FavGame\DominoesGame\Tests\Dices;

use FavGame\DominoesGame\Dices\Dice;
use FavGame\DominoesGame\Dices\DiceSide;
use FavGame\DominoesGame\Dices\InvalidBindingException;
use FavGame\DominoesGame\Id;
use PHPUnit\Framework\TestCase;

final class DiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testBinding(): void
    {
        $diceA = new Dice(Id::next(), new DiceSide(1), new DiceSide(2));
        $this->assertFalse($diceA->isUsed());
        $diceA->setBinding($diceA);
        $this->assertTrue($diceA->isUsed());

        $diceB = new Dice(Id::next(), new DiceSide(1), new DiceSide(3));
        $this->assertFalse($diceB->isUsed());
        $diceB->setBinding($diceA);
        $this->assertTrue($diceA->isUsed());
        $this->assertTrue($diceB->isUsed());
    }

    /**
     * @return void
     */
    public function testInvalidBinding(): void
    {
        $this->expectException(InvalidBindingException::class);

        $diceA = new Dice(Id::next(), new DiceSide(0), new DiceSide(0));
        $diceA->setBinding($diceA);

        $diceB = new Dice(Id::next(), new DiceSide(1), new DiceSide(1));
        $diceB->setBinding($diceA);
    }
}
