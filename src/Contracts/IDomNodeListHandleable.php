<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface IDomNodeListHandleable
{
    /**
     * @param \DOMNodeList $nodeList
     *
     * @return \DOMNode[]
     */
    public function toArray(\DOMNodeList $nodeList): array;
}
