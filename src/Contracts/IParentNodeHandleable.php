<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface IParentNodeHandleable
{
    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function closest(string $node_name, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return \DOMNode|null
     */
    public function root(INodeListInstance $nodeList): ?\DOMNode;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function parent(INodeListInstance $nodeList): INodeListInstance;
}
