<?php

namespace Dominoes\Events;

use Dominoes\Id;

interface EventInterface
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
