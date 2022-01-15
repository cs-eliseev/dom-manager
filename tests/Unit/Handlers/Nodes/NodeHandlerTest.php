<?php

declare(strict_types=1);

namespace Unit\Handlers\Nodes;

use cse\DOMManager\Handlers\DomNode\DomNodeHandler;
use cse\DOMManager\Handlers\DomNode\DomNodeListHandler;
use cse\DOMManager\Handlers\DomNode\XPathHandler;
use cse\DOMManager\Handlers\Nodes\NodeHandler;
use cse\DOMManager\Nodes\NodeList;

class NodeHandlerTest extends \Tests\BaseTestCase
{
    /** @var NodeHandler $nodeHandler */
    protected $nodeHandler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->nodeHandler = new NodeHandler(new DomNodeHandler(new XPathHandler()), new DomNodeListHandler());
    }

    /**
     * @param string $node_name
     * @param string $elem_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider appendChildesProvider
     *
     * @throws \Exception
     */
    public function testAppendChildes(string $node_name, string $elem_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->appendChildes(
                $elem_name,
                $this->getNodeListDocumentByElem($node_name),
                $this->getNodeListByFile(self::FILE_ITEM)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function appendChildesProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'elem_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><br/><p>Last text</p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'elem_name' => 'div',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><br/><p>Last text</p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'main',
                'elem_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'elem_name' => 'h1',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'elem_name' => 'div/h1',
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'main',
                'elem_name' => 'p',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p></div><br/><p>Last text<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p></div><div class="description" role="contentinfo"><p>First description<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p><br/><em>Middle description</em><p><span>Last description</span><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'elem_name' => 'br',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></br><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></br><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'elem_name' => 'hr',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>'
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function testAppendChildesOnlyContent(): void
    {
        $nodeList = $this->getNodeListByFile(self::FILE_ITEM);
        $this->assertEquals(
            $this->nodeHandler->appendChildes(
                '',
                new NodeList(),
                $nodeList
            ),
            $nodeList
        );
    }

    /**
     * @return void
     */
    public function testAppendChildesEmptyNodeList(): void
    {
        $nodeList = $this->getNodeListByFile();
        $this->assertEquals($this->nodeHandler->appendChildes('hr', $nodeList, new NodeList()), $nodeList);
        $this->assertEquals($this->nodeHandler->appendChildes('hr', new NodeList(), $nodeList), $nodeList);
    }

    /**
     * @param string $node_name
     * @param string $elem_name
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider contentProvider
     */
    public function testContent(string $node_name, string $elem_name, string $equals): void
    {
        $this->assertEquals(
            $this->nodeHandler->toString(
                $elem_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function contentProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'elem_name' => 'img',
                'equals' => '<img src="content_img.jpg" alt="content img"/>',
            ],
            [
                'node_name' => 'main',
                'elem_name' => 'hr',
                'equals' => '',
            ],
            [
                'node_name' => 'main',
                'elem_name' => 'em',
                'equals' => '<em>Middle description</em>',
            ],
            [
                'node_name' => 'div',
                'elem_name' => 'em',
                'equals' => '<em>Middle description</em>',
            ],
            [
                'node_name' => 'div',
                'elem_name' => 'h1',
                'equals' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>' . PHP_EOL . '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
            [
                'node_name' => 'div',
                'elem_name' => 'div/h1',
                'equals' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
            [
                'node_name' => 'main',
                'elem_name' => 'p',
                'equals' => '<p><span class="text">First text</span></p>' . PHP_EOL . '<p>Last text</p>' . PHP_EOL . '<p>First description</p>' . PHP_EOL . '<p><span>Last description</span></p>',
            ],
            [
                'node_name' => 'div',
                'elem_name' => 'p',
                'equals' => '<p><span class="text">First text</span></p>' . PHP_EOL . '<p>Last text</p>' . PHP_EOL . '<p><span class="text">First text</span></p>' . PHP_EOL . '<p>First description</p>' . PHP_EOL . '<p><span>Last description</span></p>',
            ],
            [
                'node_name' => 'p',
                'elem_name' => 'span',
                'equals' => '<span class="text">First text</span>' . PHP_EOL . '<span>Last description</span>',
            ],
            [
                'node_name' => 'p',
                'elem_name' => 'span[contains(@class, "text")]',
                'equals' => '<span class="text">First text</span>',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $child
     * @param int $count
     *
     * @return void
     *
     * @dataProvider countProvider
     */
    public function testCount(string $node_name, string $child, int $count): void
    {
        $this->assertEquals(
            $this->nodeHandler->count(
                $child,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $count
        );
    }

    /**
     * @return array[]
     */
    public function countProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'child' => 'img',
                'count' => 1,
            ],
            [
                'node_name' => 'main',
                'child' => 'hr',
                'count' => 0,
            ],
            [
                'node_name' => 'main',
                'child' => 'div',
                'count' => 3,
            ],
            [
                'node_name' => 'div',
                'child' => 'p',
                'count' => 5,
            ],
            [
                'node_name' => 'main',
                'child' => 'p',
                'count' => 4,
            ],
            [
                'node_name' => 'main',
                'child' => 'div/p',
                'count' => 3,
            ],
            [
                'node_name' => 'div',
                'child' => 'div/p',
                'count' => 1,
            ],
            [
                'node_name' => 'div',
                'child' => 'span',
                'count' => 5,
            ],
            [
                'node_name' => 'main',
                'child' => 'main',
                'count' => 0,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider findProvider
     *
     * @throws \Exception
     */
    public function testFind(string $node_name, string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->find(
                $find_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function findProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'equals' => [
                    '<img src="content_img.jpg" alt="content img"/>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'h1',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p><span class="text">First text</span></p>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div/p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'em',
                'equals' => [
                    '<em>Middle description</em>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param bool $is_all
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider findChildByNodeNameProvider
     *
     * @throws \Exception
     */
    public function testFindChildByNodeName(string $node_name, string $find_name, bool $is_all, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->findChildByNodeName(
                $find_name,
                $this->getNodeListDocumentByElem($node_name),
                $is_all
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function findChildByNodeNameProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'is_all' => true,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'main',
                'is_all' => true,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'is_all' => true,
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<br/>',
                    '<p>Last text</p>',
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<img src="content_img.jpg" alt="content img"/>',
                    '<p><span class="text">First text</span></p>',
                    '<p>First description</p>',
                    '<br/>',
                    '<em>Middle description</em>',
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'is_all' => false,
                'equals' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<p>First description</p>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div/div',
                'is_all' => true,
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<img src="content_img.jpg" alt="content img"/>',
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div/div',
                'is_all' => false,
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'is_all' => true,
                'equals' => [
                    '<span class="text">First text</span>',
                    '<span class="text">First text</span>',
                    '<span>Last description</span>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'is_all' => false,
                'equals' => [
                    '<span class="text">First text</span>',
                    '<span class="text">First text</span>',
                    '<span>Last description</span>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'is_all' => true,
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider findNodesProvider
     *
     * @throws \Exception
     */
    public function testFindNodes(string $node_name, string $find_name, ?array $equals): void
    {
        $this->assertEqualsTagsNodeList(
            $this->nodeHandler->findNodes(
                $find_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function findNodesProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'main',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'equals' => [
                    'img'
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'equals' => [
                    'div',
                    'div',
                    'div',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'equals' => [
                    'br',
                    'br',
                ],
            ],
            [
                'node_name' => 'main',
                'child' => 'br',
                'equals' => [
                    'br',
                    'br',
                ],
            ],
            [
                'node_name' => 'main',
                'child' => 'p',
                'equals' => [
                    'p',
                    'p',
                    'p',
                    'p',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    'p',
                    'p',
                    'p',
                    'p',
                    'p',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div/p',
                'equals' => [
                    'p',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param int $position
     * @param array|null $equals
     *
     * @return void
     *
     * @throws \Exception
     *
     * @dataProvider findNodesByPositionProvider
     */
    public function testFindNodesByPosition(string $node_name, string $find_name, int $position, ?array $equals): void
    {
        $this->assertEqualsTagsNodeList(
            $this->nodeHandler->findNodesByPosition(
                $find_name,
                $position,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function findNodesByPositionProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'position' => 0,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'main',
                'position' => 0,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'position' => 0,
                'equals' => [
                    'img'
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'position' => 1,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'position' => 0,
                'equals' => [
                    'div',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'position' => 1,
                'equals' => [
                    'div',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'position' => 2,
                'equals' => [
                    'div',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'position' => 3,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'child' => 'br',
                'position' => 0,
                'equals' => [
                    'br',
                ],
            ],
            [
                'node_name' => 'main',
                'child' => 'br',
                'position' => 1,
                'equals' => [
                    'br',
                ],
            ],
            [
                'node_name' => 'main',
                'child' => 'br',
                'position' => 2,
                'equals' => null,
            ],
            [
                'node_name' => 'div',
                'child' => 'br',
                'position' => 0,
                'equals' => [
                    'br',
                    'br',
                ],
            ],
            [
                'node_name' => 'div',
                'child' => 'br',
                'position' => 1,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'child' => 'p',
                'position' => 0,
                'equals' => [
                    'p',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'position' => 0,
                'equals' => [
                    'p',
                    'p',
                    'p',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'position' => 1,
                'equals' => [
                    'p',
                    'p',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'position' => 2,
                'equals' => null,
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div/p',
                'position' => 0,
                'equals' => [
                    'p',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div/p',
                'position' => 1,
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider firstNodesProvider
     *
     * @throws \Exception
     */
    public function testFirstNodes(string $node_name, string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->firstNodes(
                $find_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function firstNodesProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'main',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'equals' => [
                    '<img src="content_img.jpg" alt="content img"/>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'br',
                'equals' => [
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p><span class="text">First text</span></p>',
                    '<p>First description</p>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider lastNodesProvider
     */
    public function testLastNodes(string $node_name, string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->lastNodes(
                $find_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function lastNodesProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'main',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'equals' => [
                    '<img src="content_img.jpg" alt="content img"/>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'br',
                'equals' => [
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p>Last text</p>',
                    '<p><span>Last description</span></p>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param array $equals
     *
     * @return void
     *
     * @dataProvider removeProvider
     *
     * @throws \Exception
     */
    public function testRemove(string $node_name, string $find_name, array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->remove(
                $find_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
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
                'node_name' => 'main',
                'find_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"/>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'p',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div><br/></div><div class="description" role="contentinfo"><br/><em>Middle description</em></div></main>'
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div><br/></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div>',
                    '<div class="description" role="contentinfo"><br/><em>Middle description</em></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div/p',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'h1',
                'equals' => [
                    '<div class="content"><div><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div',
                'equals' => [
                    '<div class="content"><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param string $new_name
     * @param array $equals
     *
     * @return void
     *
     * @dataProvider renameProvider
     *
     * @throws \Exception
     */
    public function testRename(string $node_name, string $find_name, string $new_name, array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->rename(
                $new_name,
                $find_name,
                $this->getNodeListDocumentByElem($node_name)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function renameProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => 'hr',
                'new_name' => 'line',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'new_name' => 'a',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><a src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'em',
                'new_name' => 'i',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><i>Middle description</i><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'new_name' => 'section',
                'equals' => [
                    '<main class="main" role="main"><section class="content"><section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section><br/><p>Last text</p></section><section class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></section></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div',
                'new_name' => 'section',
                'equals' => [
                    '<div class="content"><section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section><br/><p>Last text</p></div>',
                    '<div/>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'p',
                'new_name' => 'i',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><i><span class="text">First text</span></i></div><br/><i>Last text</i></div><div class="description" role="contentinfo"><i>First description</i><br/><em>Middle description</em><i><span>Last description</span></i></div></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'new_name' => 'i',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><i><span class="text">First text</span></i></div><br/><i>Last text</i></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><i><span class="text">First text</span></i></div>',
                    '<div class="description" role="contentinfo"><i>First description</i><br/><em>Middle description</em><i><span>Last description</span></i></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div/p',
                'new_name' => 'i',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><i><span class="text">First text</span></i></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><i><span class="text">First text</span></i></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'new_name' => 'hr',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><hr/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><hr/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param array $equals
     *
     * @return void
     *
     * @dataProvider replaceProvider
     *
     * @throws \Exception
     */
    public function testReplace(string $node_name, string $find_name, array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeHandler->replace(
                $find_name,
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
                'node_name' => 'main',
                'find_name' => 'hr',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'img',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>'
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'em',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'find_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div',
                'equals' => [
                    '<div class="content"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><div role="article"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div></div><br/><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><div role="article"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div></div>',
                    '<div class="description" role="contentinfo"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><br/><em>Middle description</em><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'div/p',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><div role="article"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><div role="article"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function testReplaceEmptyNodeList(): void
    {
        $nodeList = $this->getNodeListByFile();
        $this->assertEquals($this->nodeHandler->replace('hr', $nodeList, new NodeList()), $nodeList);
        $this->assertEquals($this->nodeHandler->replace('hr', new NodeList(), $nodeList), $nodeList);
    }
}
