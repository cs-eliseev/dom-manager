<?php

declare(strict_types=1);

namespace cse\DOMManager;

use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodesInstance;
use cse\DOMManager\Nodes\Nodes;
use cse\DOMManager\Nodes\NodesFactory;

class DomManager
{
    /** @var NodesFactory $factory */
    protected $factory;

    /**
     * DomManager constructor.
     */
    public function __construct()
    {
        $this->factory = new NodesFactory();
    }

    /**
     * @param string|array|INodesInstance|INodeListInstance|\DOMNode|\DOMNodeList|\DOMDocument|null $content
     *
     * @return Nodes
     */
    public function create($content = null): Nodes
    {
        $nodes = $this->factory->create();
        if (!empty($content)) {
            $nodes->add($content);
        }

        return $nodes;
    }
}
