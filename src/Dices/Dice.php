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
     * @param int $value
     * @return DiceSide|null
     */
    public function getFreeSideByValue(int $value): ?DiceSide
    {
        if (!$this->getSideA()->isBinding() && $this->getSideA()->getValue() == $value) {
            return $this->getSideA();
        }

        if (!$this->getSideB()->isBinding() && $this->getSideB()->getValue() == $value) {
            return $this->getSideB();
        }

        return null;
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
        if (!$this->getSideA()->isBinding() && $dice->getFreeSideByValue($this->getSideA()->getValue()) !== null) {
            return true;
        }

        if (!$this->getSideB()->isBinding() && $dice->getFreeSideByValue($this->getSideB()->getValue()) !== null) {
            return true;
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
        $side = null;

        if (!$dice->isUsed()) {
            throw new InvalidBindingException();
        }

        if (!$this->getSideA()->isBinding()) {
            $side = $dice->getFreeSideByValue($this->getSideA()->getValue());
            $side->setBinding($this->getSideA());
            $this->getSideA()->setBinding($side);
        }

        if (!$this->getSideB()->isBinding()) {
            $side = $dice->getFreeSideByValue($this->getSideB()->getValue());
            $side->setBinding($this->getSideA());
            $this->getSideB()->setBinding($side);
        }

        if ($side === null) {
            throw new InvalidBindingException();
        }

        $this->isUsed = true;
    }

    /**
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->isUsed;
    }
}
