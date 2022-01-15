<?php

declare(strict_types=1);

namespace Unit\Nodes;

use cse\DOMManager\Contracts\IChildNodeHandleable;
use cse\DOMManager\Contracts\IContentParsable;
use cse\DOMManager\Contracts\IDomNodeHandleable;
use cse\DOMManager\Contracts\IDomNodeListHandleable;
use cse\DOMManager\Contracts\IDomNodeXPathHandleable;
use cse\DOMManager\Contracts\INodeHandleable;
use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodeListHandleable;
use cse\DOMManager\Contracts\IParentNodeHandleable;
use cse\DOMManager\Nodes\Nodes;
use cse\DOMManager\Nodes\NodesFactory;

class NodesFactoryTest extends \Tests\BaseTestCase
{
    /** @var NodesFactory $factory */
    protected $factory;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new NodesFactory();
    }

    /**
     * @return void
     */
    public function testBaseCreate(): void
    {
        $this->assertInstanceOf(Nodes::class, $this->factory->create());
    }

    /**
     * @return void
     */
    public function testCustomCreate(): void
    {
        $this->factory->setNodeList(\Mockery::mock(INodeListInstance::class))
            ->setContentParser(\Mockery::mock(IContentParsable::class))
            ->setDomNodeHandler(\Mockery::mock(IDomNodeHandleable::class))
            ->setDomNodeListHandler(\Mockery::mock(IDomNodeListHandleable::class))
            ->setXPathHandler(\Mockery::mock(IDomNodeXPathHandleable::class))
            ->setChildesNodeHandler(\Mockery::mock(IChildNodeHandleable::class))
            ->setNodeHandler(\Mockery::mock(INodeHandleable::class))
            ->setNodeListHandler(\Mockery::mock(INodeListHandleable::class))
            ->setParentNodeHandler(\Mockery::mock(IParentNodeHandleable::class));

        $this->assertInstanceOf(Nodes::class, $this->factory->create());
    }
}
