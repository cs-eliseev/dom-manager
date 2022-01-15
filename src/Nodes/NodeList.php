<?php

declare(strict_types=1);

namespace cse\DOMManager\Nodes;

use Closure;
use cse\DOMManager\Contracts\INodeListInstance;
use DOMNode;

class NodeList implements INodeListInstance
{
    /** @var DOMNode[] $list */
    protected $list = [];

    /**
     * @param DOMNode $node
     *
     * @return NodeList
     */
    public function push(DOMNode $node): INodeListInstance
    {
        $this->list[] = $node;

        return $this;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function replace(INodeListInstance $nodeList): INodeListInstance
    {
        $this->list = $nodeList->all();

        return $this;
    }

    /**
     * @return DOMNode|null
     */
    public function pop(): ?DOMNode
    {
        return $this->isEmpty() ? null : array_shift($this->list);
    }

    /**
     * @param int $index
     *
     * @return DOMNode|null
     */
    public function peek(int $index = 0): ?DOMNode
    {
        return $this->list[$index] ?? null;
    }

    /**
     * @return DOMNode[]
     */
    public function pull(): array
    {
        $list = $this->list;
        $this->list = [];

        return $list;
    }

    /**
     * @return DOMNode[]
     */
    public function all(): array
    {
        return $this->list;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->list);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return bool
     */
    public function exist(): bool
    {
        return $this->count() !== 0;
    }

    /**
     * @param Closure $closure
     *
     * @return DOMNode[]
     */
    public function each(Closure $closure): array
    {
        $data = [];
        foreach ($this->list as $key => $domNode) {
            $data[] = $closure($domNode, $key);
        }

        return $data;
    }

    /**
     * @return NodeList
     */
    public function copy(): INodeListInstance
    {
        return clone $this;
    }

    /**
     * @return NodeList
     */
    public function new(): INodeListInstance
    {
        return self::create();
    }

    /**
     * @return NodeList
     */
    public static function create(): INodeListInstance
    {
        return new self();
    }
}
