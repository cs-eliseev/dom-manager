<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\Nodes;

use cse\DOMManager\Contracts\IChildNodeHandleable;
use cse\DOMManager\Contracts\IDomNodeHandleable;
use cse\DOMManager\Contracts\IDomNodeListHandleable;
use cse\DOMManager\Contracts\INodeListInstance;

final class ChildesNodeHandler implements IChildNodeHandleable
{
    /** @var IDomNodeHandleable $domNodeHandler */
    protected $domNodeHandler;

    /** @var IDomNodeListHandleable $domNodeListHandler */
    protected $domNodeListHandler;

    /**
     * NodeHandler constructor.
     *
     * @param IDomNodeHandleable $domNodeHandler
     * @param IDomNodeListHandleable $domNodeListHandler
     */
    public function __construct(
        IDomNodeHandleable  $domNodeHandler,
        IDomNodeListHandleable $domNodeListHandler
    ) {
        $this->domNodeHandler = $domNodeHandler;
        $this->domNodeListHandler = $domNodeListHandler;
    }

    /**
     * @param INodeListInstance $nodeList
     * @param bool $is_all
     *
     * @return INodeListInstance
     */
    public function pull(INodeListInstance $nodeList, bool $is_all): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            if (!$domNode->hasChildNodes()) {
                continue;
            }

            $next = false;
            foreach ($this->domNodeListHandler->toArray($domNode->childNodes) as $childDomNode) {
                if ($this->domNodeHandler->isElem($childDomNode)) {
                    $nodeList->push($childDomNode);
                    $next = true;
                }

                if (!$is_all && $next) {
                    break;
                }
            }
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function remove(INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->all() as $domNode) {
            if (!$domNode->hasChildNodes()) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNode->childNodes) as $childDomNode) {
                if ($this->domNodeHandler->isElem($childDomNode)) {
                    $domNode->removeChild($childDomNode);
                }
            }
        }

        return $nodeList;
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function removeByName(string $node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->all() as $domNode) {
            if (!$domNode->hasChildNodes()) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNode->childNodes) as $childDomNode) {
                if ($childDomNode->nodeName == $node_name) {
                    $domNode->removeChild($childDomNode);
                }
            }
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newChildNodeList
     *
     * @return INodeListInstance
     */
    public function replace(INodeListInstance $nodeList, INodeListInstance $newChildNodeList): INodeListInstance
    {
        if ($newChildNodeList->isEmpty()) {
            return $nodeList;
        }

        $newChildDomNode = $newChildNodeList->pop();
        foreach ($nodeList->all() as $domNode) {
            if (!$domNode->hasChildNodes()) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNode->childNodes) as $childDomNode) {
                if ($this->domNodeHandler->isElem($childDomNode)) {
                    $this->domNodeHandler->replace($childDomNode, $newChildDomNode);
                }
            }
        }

        return $nodeList;
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newChildNodeList
     *
     * @return INodeListInstance
     */
    public function replaceByName(string $node_name, INodeListInstance $nodeList, INodeListInstance $newChildNodeList): INodeListInstance
    {
        if ($newChildNodeList->isEmpty()) {
            return $nodeList;
        }

        $newChileDomNode = $newChildNodeList->pop();
        foreach ($nodeList->all() as $domNode) {
            if (!$domNode->hasChildNodes()) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNode->childNodes) as $childDomNode) {
                if ($childDomNode->nodeName == $node_name) {
                    $this->domNodeHandler->replace($childDomNode, $newChileDomNode);
                }
            }
        }

        return $nodeList;
    }
}
