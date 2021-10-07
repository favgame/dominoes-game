<?php

namespace Domino;

final class DiceList
{
    private array $items = [];

    public function addItem(Dice $dice): void
    {
        $this->items[] = $dice;
    }

    public function getAll(): array
}
