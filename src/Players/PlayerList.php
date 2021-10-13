<?php

namespace Dominoes\Players;

use Dominoes\AbstractList;

use ArrayObject;

final class PlayerList extends AbstractList
{
    /**
     * @param PlayerInterface $item
     */
    public function addItem(PlayerInterface $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return ArrayObject|PlayerInterface[]
     */
    public function getItems(): ArrayObject
    {
        return new ArrayObject($this->items);
    }
}
