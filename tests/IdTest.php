<?php

namespace FavGame\DominoesGame\Tests;

use FavGame\DominoesGame\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    /**
     * @return void
     */
    public function testNext(): void
    {
        $id = Id::next();
        $this->assertGreaterThan($id->getValue(), Id::next()->getValue());
    }
}
