<?php

namespace Dominoes\Events;

use Dominoes\Id;
use DateTimeInterface;

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

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface;
}
