<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface INodeHandleable
{
    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function appendChildes(string $node_name, INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function toString(string $node_name, INodeListInstance $nodeList): string;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return int
     */
    public function count(string $node_name, INodeListInstance $nodeList): int;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function find(string $node_name, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param bool $is_all
     *
     * @return INodeListInstance
     */
    public function findChildByNodeName(string $node_name, INodeListInstance $nodeList, bool $is_all = false): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function findNodes(string $node_name, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param int $position
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function findNodesByPosition(string $node_name, int $position, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function remove(string $node_name, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param string $new_node_name
     * @param string $old_node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function rename(string $new_node_name, string $old_node_name, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function replace(string $node_name, INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function firstNodes(string $node_name, INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param string $node_name
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function lastNodes(string $node_name, INodeListInstance $nodeList): INodeListInstance;
}
