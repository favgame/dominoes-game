<?php

namespace FavGame\Dominoes\Bots;

use FavGame\Dominoes\Id;
use FavGame\Dominoes\Players\PlayerInterface;

/**
 * Абстрактный компьютерный соперник
 */
abstract class AbstractBot implements PlayerInterface
{
    /**
     * @var Id Идентификатор игрока
     */
    private Id $id;

    /**
     * @var string Имя игрока
     */
    private string $name;

    /***
     * @param Id $id Идентификатор игрока
     * @param string $name Имя игрока
     */
    public function __construct(Id $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function isBot(): bool
    {
        return true;
    }
}
