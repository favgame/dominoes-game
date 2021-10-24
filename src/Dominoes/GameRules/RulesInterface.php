<?php

namespace Dominoes\GameRules;

interface RulesInterface
{
    /**
     * @return int
     */
    public function getMinPlayerCount(): int;

    /**
     * @return int
     */
    public function getMaxPlayerCount(): int;

    /**
     * @return int
     */
    public function getMaxPointAmount(): int;

    /**
     * @return int
     */
    public function getMaxSideValue(): int;

    /**
     * @return int
     */
    public function getInitialDiceCount(): int;
}
