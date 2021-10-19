<?php

namespace Dominoes;

final class Id
{
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return static
     */
    public static function next(): self
    {
        return new self(uniqid('', true));
    }
}
