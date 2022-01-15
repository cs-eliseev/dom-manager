<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;

class NodeListParser extends AbstractParser
{
    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function convertToNodes(INodeListInstance $nodeList): INodeListInstance
    {
        return clone $nodeList;
    }

    /**
     * @param INodeListInstance $content
     *
     * @return INodeListInstance
     */
    protected function handle($content): INodeListInstance
    {
        return $this->convertToNodes($content);
    }
}
