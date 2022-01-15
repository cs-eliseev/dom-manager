<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface INodesFactory
{
    /**
     * @return INodesInstance
     */
    public function create(): INodesInstance;
}
