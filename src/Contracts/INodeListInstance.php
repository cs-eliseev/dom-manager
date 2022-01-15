<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface INodeListInstance
{
    /**
     * @param \DOMNode $node
     *
     * @return INodeListInstance
     */
    public function push(\DOMNode $node): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function replace(INodeListInstance $nodeList): INodeListInstance;

    /**
     * @return \DOMNode|null
     */
    public function pop(): ?\DOMNode;

    /**
     * @param int $index
     *
     * @return \DOMNode|null
     */
    public function peek(int $index = 0);

    /**
     * @return \DOMNode[]
     */
    public function pull(): array;

    /**
     * @return \DOMNode[]
     */
    public function all(): array;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return bool
     */
    public function exist(): bool;

    /**
     * @param \Closure $closure
     *
     * @return \DOMNode[]
     */
    public function each(\Closure $closure): array;

    /**
     * @return INodeListInstance
     */
    public function copy(): INodeListInstance;

    /**
     * @return INodeListInstance
     */
    public function new(): INodeListInstance;

    /**
     * @return INodeListInstance
     */
    public static function create(): INodeListInstance;
}
