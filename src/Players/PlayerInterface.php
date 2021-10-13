<?php

namespace Dominoes\Players;

use Dominoes\Events\EventListenerInterface;
use Dominoes\Id;

interface PlayerInterface extends EventListenerInterface
{
    /**
     * @return Id
     */
    public function getId(): Id;

    /**
     * @return string
     */
    public function getName(): string;
}
