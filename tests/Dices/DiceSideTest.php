<?php

namespace FavGame\Dominoes\Tests\Dices;

use FavGame\Dominoes\Dices\DiceSide;
use FavGame\Dominoes\Dices\InvalidBindingException;
use PHPUnit\Framework\TestCase;

final class DiceSideTest extends TestCase
{
    /**
     * @return void
     */
    public function testBinding(): void
    {
        $sideA = new DiceSide(1);
        $sideB = new DiceSide(1);
        $sideA->setBinding($sideB);
        $this->assertEquals($sideA->getValue(), $sideB->getValue());
    }

    /**
     * @return void
     */
    public function testCanBinding(): void
    {
        $sideA = new DiceSide(1);
        $sideB = new DiceSide(1);
        $sideC = new DiceSide(2);

        $this->assertFalse($sideA->canBinding($sideA));
        $this->assertFalse($sideA->canBinding($sideC));

        $this->assertTrue($sideA->canBinding($sideB));
        $sideA->setBinding($sideB);
        $this->assertFalse($sideA->canBinding($sideB));
    }

    /**
     * @return void
     */
    public function testInvalidBinding(): void
    {
        $this->expectException(InvalidBindingException::class);

        $sideA = new DiceSide(0);
        $sideB = new DiceSide(1);

        $sideB->setBinding($sideA);
    }
}
