<?php

namespace Dominoes\Dices;

use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

final class Dice
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var DiceSide
     */
    private DiceSide $sideA;

    /**
     * @var DiceSide
     */
    private DiceSide $sideB;

    /**
     * @var int
     */
    private int $pointAmount;

    /**
     * @var PlayerInterface|null
     */
    private ?PlayerInterface $owner = null;

    /**
     * @param Id $id
     * @param DiceSide $sideA
     * @param DiceSide $sideB
     */
    public function __construct(Id $id, DiceSide $sideA, DiceSide $sideB)
    {
        $this->id = $id;
        $this->sideA = $sideA;
        $this->sideB = $sideB;
        $this->pointAmount = $this->sideA->getValue() + $this->sideB->getValue();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return DiceSide
     */
    public function getSideA(): DiceSide
    {
        return $this->sideA;
    }

    /**
     * @return DiceSide
     */
    public function getSideB(): DiceSide
    {
        return $this->sideB;
    }

    /**
     * @return int
     */
    public function getPointAmount(): int
    {
        return $this->pointAmount;
    }

    /**
     * @return PlayerInterface|null
     */
    public function getOwner(): ?PlayerInterface
    {
        return $this->owner;
    }

    /**
     * @return bool
     */
    public function hasOwner(): bool
    {
        return ($this->owner !== null);
    }

    /**
     * @param PlayerInterface $owner
     * @return void
     */
    public function setOwner(PlayerInterface $owner): void
    {
        $this->owner = $owner;
       // TODO: exception if owned
    }
}
