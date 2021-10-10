<?php

namespace Dominos;

final class Id
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $value;
    }

    public static function next(): self
    {
        return new self(uniqid('', true));
    }
}
