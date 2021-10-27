<?php

namespace Dominoes;

final class Id
{
    /**
     * @var int
     */
    private int $value;

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
     * @return static
     */
    public static function next(): self
    {
        return new self(hexdec(uniqid()));
    }
}
