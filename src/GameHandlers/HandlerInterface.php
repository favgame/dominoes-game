<?php

namespace Dominoes\GameHandlers;

interface HandlerInterface
{
    /**
     * @return void
     */
    public function handleData(): void;

    /**
     * @param HandlerInterface $handler
     * @return void
     */
    public function setNextHandler(self $handler): void;
}
