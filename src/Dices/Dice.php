<?php

namespace Dominos;

final class Dice
{
    private DiceSide $sideA;

    private DiceSide $sideB;

    private ?PlayerInterface $owner = null;

    public function __construct(DiceSide $sideA, DiceSide $sideB)
    {
        $this->sideA = $sideA;
        $this->sideB = $sideB;
    }

    public function getSideA(): DiceSide
    {
        return $this->sideA;
    }

    public function getSideB(): DiceSide
    {
        return $this->sideB;
    }

    public function getOwner(): ?PlayerInterface
    {
        return $this->owner;
    }

    public function hasOwner(): bool
    {
        return ($this->owner !== null);
    }

    public function setOwner(PlayerInterface owner): void
    {
        $this->owner = $owner;
       // TODO: exception if owned
    }
}
