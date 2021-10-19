<?php

namespace Dominoes\Players;

use Dominoes\AbstractList;

use ArrayObject;

/**
 * @method ArrayObject|PlayerInterface[] getItems()
 */
final class PlayerList extends AbstractList
{
    /**
     * @param PlayerInterface $item
     */
    public function addItem(PlayerInterface $item): void
    {
        $this->items[] = $item;
    }
}
