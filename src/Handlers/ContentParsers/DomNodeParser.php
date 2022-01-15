<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;
use DOMNode;

class DomNodeParser extends AbstractParser
{
    /**
     * @param DOMNode $node
     *
     * @return INodeListInstance
     */
    public function convertToNodes(DOMNode $node): INodeListInstance
    {
        return $this->nodeList->push($node);
    }

    /**
     * @param DOMNode $content
     *
     * @return INodeListInstance
     */
    protected function handle($content): INodeListInstance
    {
        return $this->convertToNodes($content);
    }
}
