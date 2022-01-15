<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodesInstance;

class NodesParser extends AbstractParser
{
    /**
     * @param INodesInstance $node
     *
     * @return INodeListInstance
     */
    public function convertToNodes(INodesInstance $node): INodeListInstance
    {
        return clone $node->toList();
    }

    /**
     * @param INodesInstance $content
     *
     * @return INodeListInstance
     */
    protected function handle($content): INodeListInstance
    {
        return $this->convertToNodes($content);
    }
}
