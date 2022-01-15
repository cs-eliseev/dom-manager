<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface IChildNodeHandleable
{
    /**
     * @param INodeListInstance $nodeList
     * @param bool $is_all
     *
     * @return INodeListInstance
     */
    public function pull(INodeListInstance $nodeList, bool $is_all): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function remove(INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function removeByName(string $node_name, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newChildNodeList
     *
     * @return INodeListInstance
     */
    public function replace(INodeListInstance $nodeList, INodeListInstance $newChildNodeList): ?INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newChildNodeList
     *
     * @return INodeListInstance
     */
    public function replaceByName(string $node_name, INodeListInstance $nodeList, INodeListInstance $newChildNodeList): INodeListInstance;
}
