<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodesInstance;
use cse\DOMManager\Contracts\IParserInstance;
use cse\DOMManager\Nodes\NodeList;

abstract class AbstractParser implements IParserInstance
{
    /** @var INodeListInstance $nodeList */
    protected $nodeList;

    /**
     * @param INodeListInstance|INodesInstance|\DOMNode|\DOMNodeList|\DOMDocument|string $content
     *
     * @return INodeListInstance
     */
    abstract protected function handle($content): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return AbstractParser
     */
    public function setNodeList(INodeListInstance $nodeList): AbstractParser
    {
        $this->nodeList = $nodeList;

        return $this;
    }

    /**
     * @param INodeListInstance|INodesInstance|\DOMNode|\DOMNodeList|string|string[] $content
     *
     * @return INodeListInstance
     */
    public function parse($content): INodeListInstance
    {
        if (is_null($this->nodeList)) {
            $this->nodeList = new NodeList();
        }

        return $this->handle($content);
    }
}
