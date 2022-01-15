<?php

declare(strict_types=1);

namespace Unit\Handlers\Nodes;

use cse\DOMManager\Handlers\DomNode\DomNodeHandler;
use cse\DOMManager\Handlers\DomNode\DomNodeListHandler;
use cse\DOMManager\Handlers\DomNode\XPathHandler;
use cse\DOMManager\Handlers\Nodes\ChildesNodeHandler;
use cse\DOMManager\Nodes\NodeList;

class ChildesNodeHandlerTest extends \Tests\BaseTestCase
{
    /** @var ChildesNodeHandler $childesNodeHandler */
    protected $childesNodeHandler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->childesNodeHandler = new ChildesNodeHandler(
            new DomNodeHandler(new XPathHandler()),
            new DomNodeListHandler()
        );
    }

    /**
     * @param string $node_name
     * @param bool $is_all
     * @param array|null $equals
     *
     * @return void
     *
     * @throws \Exception
     *
     * @dataProvider pullProvider
     */
    public function testPull(string $node_name, bool $is_all, ?array $equals): void
    {

        $this->assertEqualsNodeListContent(
            $this->childesNodeHandler->pull(
                $this->getNodeListDocumentByElem($node_name),
                $is_all
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function pullProvider(): array
    {
        return [
            [
                'node_name' => 'div',
                'is_all' => false,
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<p>First description</p>',
                ],
            ],
            [
                'node_name' => 'div',
                'is_all' => true,
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<img src="content_img.jpg" alt="content img"/>',
                    '<p><span class="text">First text</span></p>',
                    '<br/>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<br/>',
                    '<em>Middle description</em>',
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'node_name' => 'h1',
                'is_all' => false,
                'equals' => [
                    '<i class="icon"/>',
                ],
            ],
            [
                'node_name' => 'h1',
                'is_all' => true,
                'equals' => [
                    '<i class="icon"/>',
                    '<span>Header</span>',
                ],
            ],
            [
                'node_name' => 'br',
                'is_all' => false,
                'equals' => null,
            ],
            [
                'node_name' => 'br',
                'is_all' => true,
                'equals' => null,
            ],
            [
                'node_name' => 'em',
                'is_all' => false,
                'equals' => null,
            ],
            [
                'node_name' => 'em',
                'is_all' => true,
                'equals' => null,
            ],
            [
                'node_name' => 'p',
                'is_all' => false,
                'equals' => [
                    '<span class="text">First text</span>',
                    '<span>Last description</span>',
                ],
            ],
            [
                'node_name' => 'p',
                'is_all' => true,
                'equals' => [
                    '<span class="text">First text</span>',
                    '<span>Last description</span>',
                ],
            ],
            [
                'node_name' => 'hr',
                'is_all' => true,
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider removeProvider
     *
     * @throws \Exception
     */
    public function testRemove(string $node_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->childesNodeHandler->remove(
                $this->getNodeListDocumentByElem($node_name)),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function removeProvider(): array
    {
        return [
            [
                'node_name' => 'div',
                'equals' => [
                    '<div/>',
                    '<div class="content"/>',
                    '<div class="description" role="contentinfo"/>',
                ],
            ],
            [
                'node_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"/>',
                ],

            ],
            [
                'node_name' => 'h1',
                'equals' => [
                    '<h1>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'p',
                'equals' => [
                    '<p/>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p/>'
                ],
            ],
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $child_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider removeByNameProvider
     *
     * @throws \Exception
     */
    public function testRemoveByName(string $node_name, string $child_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->childesNodeHandler->removeByName(
                $child_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function removeByNameProvider(): array
    {
        return [
            [
                'node_name' => 'h1',
                'child_name' => 'hr',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'h1',
                'child_name' => 'i',
                'equals' => [
                    '<h1><span>Header</span>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'main',
                'child_name' => 'em',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'child_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"/>',
                ],
            ],
            [
                'node_name' => 'p',
                'child_name' => 'span',
                'equals' => [
                    '<p/>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p/>',
                ],
            ],
            [
                'node_name' => 'div',
                'child_name' => 'p',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div><br/></div>',
                    '<div class="description" role="contentinfo"><br/><em>Middle description</em></div>',
                ],
            ],
            [
                'node_name' => 'hr',
                'child_name' => 'p',
                'equals' => null,
            ],
            [
                'node_name' => 'br',
                'child_name' => 'p',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @throws \Exception
     *
     * @dataProvider replaceProvider
     */
    public function testReplace(string $node_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->childesNodeHandler->replace(
                $this->getNodeListDocumentByElem($node_name),
                $this->getNodeListByFile(self::FILE_ITEM)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function replaceProvider(): array
    {
        return [
            [
                'node_name' => 'div',
                'equals' => [
                    '<div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                    '<div class="content"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                    '<div class="description" role="contentinfo"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                ],
            ],
            [
                'node_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></main>'
                ],
            ],
            [
                'node_name' => 'p',
                'equals' => [
                    '<p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'h1',
                'equals' => [
                    '<h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>-subheader</h1>'
                ],
            ],
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
        ];
    }

    /**
     * @return void
     */
    public function testReplaceEmptyNodeList(): void
    {
        $nodeList = $this->getNodeListByFile();
        $this->assertEquals($this->childesNodeHandler->replace($nodeList, new NodeList()), $nodeList);
        $this->assertEquals($this->childesNodeHandler->replace(new NodeList(), $nodeList), $nodeList);
    }

    /**
     * @param string $node_name
     * @param string $replace_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider replaceByNameProvider
     *
     * @throws \Exception
     */
    public function testReplaceByName(
        string $node_name,
        string $replace_name,
        ?array $equals
    ): void {
        $this->assertEqualsNodeListContent(
            $this->childesNodeHandler->replaceByName(
                $replace_name,
                $this->getNodeListDocumentByElem($node_name),
                $this->getNodeListByFile(self::FILE_ITEM)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function replaceByNameProvider(): array
    {
        return [
            [
                'node_name' => 'div',
                'replace_name' => 'br',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p>Last text</p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'replace_name' => 'img',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p><span class="text">First text</span></p></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'main',
                'replace_name' => 'p',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'replace_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></main>',
                ],
            ],
            [
                'node_name' => 'h1',
                'replace_name' => 'span',
                'equals' => [
                    '<h1><i class="icon"/><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'br',
                'replace_name' => 'p',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'hr',
                'replace_name' => 'p',
                'equals' => null,
            ],
        ];
    }

    /**
     * @return void
     */
    public function testReplaceByNameEmptyNodeList(): void
    {
        $nodeList = $this->getNodeListByFile();
        $this->assertEquals($this->childesNodeHandler->replaceByName('', $nodeList, new NodeList()), $nodeList);
        $this->assertEquals($this->childesNodeHandler->replaceByName('', new NodeList(), $nodeList), $nodeList);
    }
}
