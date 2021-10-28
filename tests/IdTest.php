<?php

namespace FavGame\Dominoes\Tests;

use FavGame\Dominoes\Id;
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
