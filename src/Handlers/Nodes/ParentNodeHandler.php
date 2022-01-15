<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\Nodes;

use cse\DOMManager\Contracts\IDomNodeHandleable;
use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\IParentNodeHandleable;
use DOMNode;

final class ParentNodeHandler implements IParentNodeHandleable
{
    /** @var IDomNodeHandleable $domNodeHandler */
    protected $domNodeHandler;

    /**
     * ParentNodeHandler constructor.
     *
     * @param IDomNodeHandleable $domNodeHandler
     */
    public function __construct(IDomNodeHandleable $domNodeHandler)
    {
        $this->domNodeHandler = $domNodeHandler;
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function closest(string $node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $parentDomNode = $this->domNodeHandler->closest($node_name, $domNode);
            if (isset($parentDomNode)) {
                $nodeList->push($parentDomNode);
            }
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return DOMNode|null
     */
    public function root(INodeListInstance $nodeList): ?DOMNode
    {
        return $nodeList->exist() ? $this->domNodeHandler->rootElement($nodeList->pop()) : null;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function parent(INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $parentDomNode = $this->domNodeHandler->parentElement($domNode);
            if (isset($parentDomNode)) {
                $nodeList->push($parentDomNode);
            }
        }

        return $nodeList;
    }
}
