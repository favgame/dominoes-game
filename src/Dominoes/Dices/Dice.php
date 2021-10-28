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
     * @var bool
     */
    private bool $isUsed = false;

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

    /**
     * @param Dice $dice
     * @return bool
     */
    public function canBinding(self $dice): bool
    {
        if ($this->isUsed() || $dice->isUsed()) {
            foreach ($this->getSides() as $selfSide) {
                foreach ($dice->getSides() as $diceSide) {
                    if ($selfSide->canBinding($diceSide) && $diceSide->canBinding($selfSide)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param Dice $dice
     * @return void
     * @throws InvalidBindingException
     */
    public function setBinding(self $dice): void
    {
        if ($dice === $this) {
            $this->isUsed = true;

            return;
        }

        if ($this->isUsed() || $dice->isUsed()) {
            foreach ($this->getSides() as $selfSide) {
                foreach ($dice->getSides() as $diceSide) {
                    if ($selfSide->canBinding($diceSide) && $diceSide->canBinding($selfSide)) {
                        $diceSide->setBinding($selfSide);
                        $selfSide->setBinding($diceSide);
                        $this->isUsed = true;
                        $dice->isUsed = true;

                        return;
                    }
                }
            }
        }

        throw new InvalidBindingException();
    }

    /**
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->isUsed;
    }

    /**
     * @return DiceSide[]
     */
    private function getSides(): array
    {
        return [$this->getSideA(), $this->getSideB()];
    }
}
