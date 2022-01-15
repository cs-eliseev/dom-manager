<?php

declare(strict_types=1);

namespace cse\DOMManager\Nodes;

use cse\DOMManager\Contracts\IChildNodeHandleable;
use cse\DOMManager\Contracts\IContentParsable;
use cse\DOMManager\Contracts\IDomNodeHandleable;
use cse\DOMManager\Contracts\IDomNodeListHandleable;
use cse\DOMManager\Contracts\IDomNodeXPathHandleable;
use cse\DOMManager\Contracts\INodeHandleable;
use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodeListHandleable;
use cse\DOMManager\Contracts\INodesInstance;
use cse\DOMManager\Contracts\INodesFactory;
use cse\DOMManager\Contracts\IParentNodeHandleable;
use cse\DOMManager\Handlers\ContentParsers\ContentParsable;
use cse\DOMManager\Handlers\DomNode\DomNodeHandler;
use cse\DOMManager\Handlers\DomNode\DomNodeListHandler;
use cse\DOMManager\Handlers\DomNode\XPathHandler;
use cse\DOMManager\Handlers\Nodes\ChildesNodeHandler;
use cse\DOMManager\Handlers\Nodes\NodeHandler;
use cse\DOMManager\Handlers\Nodes\NodeListHandler;
use cse\DOMManager\Handlers\Nodes\ParentNodeHandler;

class NodesFactory implements INodesFactory
{
    /** @var IDomNodeXPathHandleable $xPathHandler */
    protected $xPathHandler;

    /** @var IDomNodeListHandleable $domNodeListHandler */
    protected $domNodeListHandler;

    /** @var IDomNodeHandleable $domNodeHandler */
    protected $domNodeHandler;

    /** @var IParentNodeHandleable $parentNodeHandler */
    protected $parentNodeHandler;

    /** @var IChildNodeHandleable $childeNodeHandler */
    protected $nodeChildes;

    /** @var IContentParsable $contentParser */
    protected $contentParser;

    /** @var INodeHandleable $nodeHandler */
    protected $nodeHandler;

    /** @var INodeListHandleable $nodeListHandler */
    protected $nodeListHandler;

    /** @var INodeListInstance $nodeList */
    protected $nodeList;

    /**
     * @return Nodes
     */
    public function create(): INodesInstance
    {
        return new Nodes(
            $this->getNodeList(),
            $this->getNodeChildes(),
            $this->getNodeHandler(),
            $this->getNodeListHandler(),
            $this->getParentNodeHandler(),
            $this->getContentParser()
        );
    }

    /**
     * @param IDomNodeXPathHandleable $xPathHandler
     *
     * @return NodesFactory
     */
    public function setXPathHandler(IDomNodeXPathHandleable $xPathHandler): NodesFactory
    {
        $this->xPathHandler = $xPathHandler;

        return $this;
    }

    /**
     * @param IDomNodeListHandleable $domNodeListHandler
     *
     * @return NodesFactory
     */
    public function setDomNodeListHandler(IDomNodeListHandleable $domNodeListHandler): NodesFactory
    {
        $this->domNodeListHandler = $domNodeListHandler;

        return $this;
    }

    /**
     * @param IDomNodeHandleable $domNodeHandler
     *
     * @return NodesFactory
     */
    public function setDomNodeHandler(IDomNodeHandleable $domNodeHandler): NodesFactory
    {
        $this->domNodeHandler = $domNodeHandler;

        return $this;
    }

    /**
     * @param IParentNodeHandleable $parentNodeHandler
     *
     * @return NodesFactory
     */
    public function setParentNodeHandler(IParentNodeHandleable $parentNodeHandler): NodesFactory
    {
        $this->parentNodeHandler = $parentNodeHandler;

        return $this;
    }

    /**
     * @param IChildNodeHandleable $nodeChildes
     *
     * @return NodesFactory
     */
    public function setChildesNodeHandler(IChildNodeHandleable $nodeChildes): NodesFactory
    {
        $this->nodeChildes = $nodeChildes;

        return $this;
    }

    /**
     * @param INodeHandleable $nodeHandler
     *
     * @return NodesFactory
     */
    public function setNodeHandler(INodeHandleable $nodeHandler): NodesFactory
    {
        $this->nodeHandler = $nodeHandler;

        return $this;
    }

    /**
     * @param INodeListHandleable $nodeListHandler
     *
     * @return NodesFactory
     */
    public function setNodeListHandler(INodeListHandleable $nodeListHandler): NodesFactory
    {
        $this->nodeListHandler = $nodeListHandler;

        return $this;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return NodesFactory
     */
    public function setNodeList(INodeListInstance $nodeList): NodesFactory
    {
        $this->nodeList = $nodeList;

        return $this;
    }

    /**
     * @param IContentParsable $contentParser
     *
     * @return NodesFactory
     */
    public function setContentParser(IContentParsable $contentParser): NodesFactory
    {
        $this->contentParser = $contentParser;

        return $this;
    }

    /**
     * @return IDomNodeXPathHandleable
     */
    protected function getXPathHandler(): IDomNodeXPathHandleable
    {
        return $this->xPathHandler ?? new XPathHandler();
    }

    /**
     * @return IDomNodeListHandleable
     */
    protected function getDomNodeListHandler(): IDomNodeListHandleable
    {
        return $this->domNodeListHandler ?? new DomNodeListHandler();
    }

    /**
     * @return IDomNodeHandleable
     */
    protected function getDomNodeHandler(): IDomNodeHandleable
    {
        return $this->domNodeHandler ?? new DomNodeHandler($this->getXPathHandler());
    }

    /**
     * @return IParentNodeHandleable
     */
    protected function getParentNodeHandler(): IParentNodeHandleable
    {
        return $this->parentNodeHandler ?? new ParentNodeHandler($this->getDomNodeHandler());
    }

    /**
     * @return IChildNodeHandleable
     */
    protected function getNodeChildes(): IChildNodeHandleable
    {
        return $this->nodeChildes ?? new ChildesNodeHandler(
                $this->getDomNodeHandler(),
                $this->getDomNodeListHandler()
            );
    }

    /**
     * @return INodeHandleable
     */
    protected function getNodeHandler(): INodeHandleable
    {
        return $this->nodeHandler ?? new NodeHandler(
                $this->getDomNodeHandler(),
                $this->getDomNodeListHandler()
            );
    }

    /**
     * @return INodeListHandleable
     */
    protected function getNodeListHandler(): INodeListHandleable
    {
        return $this->nodeListHandler ?? new NodeListHandler(
                $this->getDomNodeHandler(),
                $this->getDomNodeListHandler()
            );
    }

    /**
     * @return INodeListInstance
     */
    protected function getNodeList(): INodeListInstance
    {
        return $this->nodeList ?? new NodeList();
    }

    /**
     * @return IContentParsable
     */
    protected function getContentParser(): IContentParsable
    {
        return $this->contentParser ?? new ContentParsable($this->getNodeList());
    }
}
