<?php

namespace Dominos/Players;

use Dominos\AbstractList;

final class PlayerList extends AbstractList
{
    public function addItem(PlayerInterface $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): ArrayObject
    {
        return new ArrayObject($this->items);
    }
}
