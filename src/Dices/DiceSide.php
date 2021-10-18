<?php

namespace Dominoes\Dices;

final class DiceSide
{
    private int $value;

    /**
     * @var static
     */
    private self $binding;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
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
        if ($side->getValue() !== $this->getValue()) {
            throw new InvalidBindingException();
        }

        $this->binding = $side;
    }

    /**
     * @return bool
     */
    public function isBinding(): bool
    {
        return ($this->binding !== null);
    }
}
