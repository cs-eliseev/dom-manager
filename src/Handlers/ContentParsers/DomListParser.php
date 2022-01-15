<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;
use DOMNode;
use DOMNodeList;

class DomListParser extends AbstractParser
{
    /**
     * @param DOMNodeList $list
     *
     * @return INodeListInstance
     */
    public function convertToNodes(DOMNodeList $list): INodeListInstance
    {
        /** @var DOMNode $domNode */
        foreach (iterator_to_array($list) as $domNode) {
            $this->nodeList->push($domNode);
        }

        return $this->nodeList;
    }

    /**
     * @param DOMNodeList $content
     *
     * @return INodeListInstance
     */
    protected function handle($content): INodeListInstance
    {
        return $this->convertToNodes($content);
    }
}
