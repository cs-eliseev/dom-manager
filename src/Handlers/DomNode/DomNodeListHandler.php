<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\DomNode;

use cse\DOMManager\Contracts\IDomNodeListHandleable;

final class DomNodeListHandler implements IDomNodeListHandleable
{
    /**
     * @param \DOMNodeList $nodeList
     *
     * @return \DOMNode[]
     */
    public function toArray(\DOMNodeList $nodeList): array
    {
        return iterator_to_array($nodeList);
    }
}
