<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\Nodes;

use cse\DOMManager\Contracts\IDomNodeHandleable;
use cse\DOMManager\Contracts\IDomNodeListHandleable;
use cse\DOMManager\Contracts\INodeHandleable;
use cse\DOMManager\Contracts\INodeListInstance;

final class NodeHandler implements INodeHandleable
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
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function appendChildes(string $node_name, INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance
    {
        if ($nodeList->isEmpty()) {
            return $newNodeList;
        } elseif ($newNodeList->isEmpty()) {
            return $nodeList;
        }

        $filter_list = [];
        foreach ($nodeList->all() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() === 0) {
                continue;
            }

            $filter_list = array_merge($filter_list, $this->domNodeListHandler->toArray($domNodeList));
        }

        foreach ($filter_list as $domNode) {
            foreach ($newNodeList->all() as $newDomNode) {
                $this->domNodeHandler->appendChild($domNode, $newDomNode);
            }
        }

        return $nodeList;
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function toString(string $node_name, INodeListInstance $nodeList): string
    {
        $list = [];
        foreach ($nodeList->all() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() === 0) {
                continue;
            }

            $document = $domNode->ownerDocument;
            foreach ($this->domNodeListHandler->toArray($domNodeList) as $filterDomNode) {
                $list[] = $document->saveXML($filterDomNode);
            }
        }

        return implode(PHP_EOL, $list);
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return int
     */
    public function count(string $node_name, INodeListInstance $nodeList): int
    {
        $count = 0;
        foreach ($nodeList->all() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            $count += $domNodeList->count();
        }

        return $count;
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function find(string $node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() == 0) {
                continue;
            }

            foreach ($domNodeList as $filterDomNode) {
                $nodeList->push($filterDomNode);
            }
        }

        return $nodeList;
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param bool $is_all
     *
     * @return INodeListInstance
     */
    public function findChildByNodeName(string $node_name, INodeListInstance $nodeList, bool $is_all = false): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() == 0) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNodeList) as $filterDomNode) {
                if (!$filterDomNode->hasChildNodes()) {
                    continue;
                }

                $next = false;
                foreach ($this->domNodeListHandler->toArray($filterDomNode->childNodes) as $childDomNOde) {
                    if ($this->domNodeHandler->isElem($childDomNOde)) {
                        $nodeList->push($childDomNOde);
                        $next = true;
                    }

                    if (!$is_all && $next) {
                        break;
                    }
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
    public function findNodes(string $node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() === 0) {
                continue;
            }

            foreach ($domNodeList as $filterDomNode) {
                $nodeList->push($filterDomNode);
            }
        }

        return $nodeList;
    }

    /**
     * @param string $node_name
     * @param int $position
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function findNodesByPosition(string $node_name, int $position, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() === 0) {
                continue;
            }

            $domNode = $domNodeList->item($position);
            if (isset($domNode)) {
                $nodeList->push($domNode);
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
    public function firstNodes(string $node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() > 0) {
                $nodeList->push($domNodeList->item(0));
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
    public function lastNodes(string $node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->pull() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            $cnt = $domNodeList->count();
            if ($cnt > 0) {
                $nodeList->push($domNodeList->item($cnt - 1));
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
    public function remove(string $node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->all() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() === 0) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNodeList) as $filterDomNode) {
                $this->domNodeHandler->remove($filterDomNode);
            }
        }

        return $nodeList;
    }

    /**
     * @param string $new_node_name
     * @param string $old_node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function rename(string $new_node_name, string $old_node_name, INodeListInstance $nodeList): INodeListInstance
    {
        foreach ($nodeList->all() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($old_node_name, $domNode);
            if ($domNodeList->count() == 0) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNodeList) as $filterDomNode) {
                $this->domNodeHandler->rename($new_node_name, $filterDomNode);
            }
        }

        return $nodeList;
    }

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function replace(string $node_name, INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance
    {
        if ($newNodeList->isEmpty()) {
            return $nodeList;
        }

        $newDomNode = $newNodeList->pop();
        foreach ($nodeList->all() as $domNode) {
            $domNodeList = $this->domNodeHandler->filter($node_name, $domNode);
            if ($domNodeList->count() === 0) {
                continue;
            }

            foreach ($this->domNodeListHandler->toArray($domNodeList) as $filterDomNode) {
                $this->domNodeHandler->replace($filterDomNode, $newDomNode);
            }
        }

        return $nodeList;
    }
}
