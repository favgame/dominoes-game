<?php

namespace Dominoes\Bots;

use Dominoes\Id;
use Dominoes\Players\PlayerInterface;

abstract class AbstractBot implements PlayerInterface
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var string
     */
    private string $name;

    /***
     * @param Id $id
     * @param string $name
     */
    public function __construct(Id $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
