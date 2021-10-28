<?php

namespace Dominoes\Dices;

final class DiceSide
{
    private int $value;

    /**
     * @var static|null
     */
    private ?self $binding = null;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param DiceSide $side
     * @return bool
     */
    public function canBinding(self $side): bool
    {
        if ($side === $this || $this->binding !== null || $side->getValue() != $this->getValue()) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param DiceSide $side
     * @return void
     * @throws InvalidBindingException
     */
    public function setBinding(self $side): void
    {
        if (!$this->canBinding($side)) {
            throw new InvalidBindingException();
        }

        $this->binding = $side;
    }
}
