<?php

declare(strict_types=1);

namespace Unit\Handlers\Nodes;

use cse\DOMManager\Handlers\DomNode\DomNodeHandler;
use cse\DOMManager\Handlers\DomNode\XPathHandler;
use cse\DOMManager\Handlers\Nodes\ParentNodeHandler;

class ParentNodeHandlerTest extends \Tests\BaseTestCase
{
    /** @var ParentNodeHandler $nodeParentHandler */
    protected $nodeParentHandler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->nodeParentHandler = new ParentNodeHandler(new DomNodeHandler(new XPathHandler()));
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider closestProvider
     *
     * @throws \Exception
     */
    public function testClosest(string $node_name, string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeParentHandler->closest(
                $find_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function closestProvider(): array
    {
        return [
            [
                'node_name' => 'span',
                'find_name' => 'div',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'p',
                'find_name' => 'div',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>'
                ],
            ],
            [
                'node_name' => 'span',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'node_name' => 'span',
                'find_name' => 'strong',
                'equals' => null
            ],
            [
                'node_name' => 'br',
                'find_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ]
            ],
            [
                'node_name' => 'i',
                'find_name' => 'h1',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                ]
            ],
        ];
    }

    /**
     * @param string $node_name
     *
     * @return void
     *
     * @dataProvider mainProvider
     */
    public function testMain(string $node_name): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $domNode = $this->nodeParentHandler->root($nodeList->copy());
        $this->assertEquals(
            $domNode,
            $nodeList->exist() ? $nodeList->pop()->ownerDocument->documentElement : null
        );
    }

    /**
     * @return array[]
     */
    public function mainProvider(): array
    {
        return [
            [
                'node_name' => 'p',
            ],
            [
                'node_name' => 'span',
            ],
            [
                'node_name' => 'em',
            ],
            [
                'node_name' => 'hr',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider parentProvider
     *
     * @throws \Exception
     */
    public function testParent(string $node_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeParentHandler->parent($this->getNodeListDocumentByElem($node_name)),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function parentProvider(): array
    {
        return [
            [
                'node_name' => 'span',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<p><span class="text">First text</span></p>',
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'node_name' => 'p',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'em',
                'equals' => [
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'equals' => null,
            ],
        ];
    }
}
