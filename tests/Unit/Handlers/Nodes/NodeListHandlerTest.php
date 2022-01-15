<?php

declare(strict_types=1);

namespace Unit\Handlers\Nodes;

use cse\DOMManager\Handlers\DomNode\DomNodeHandler;
use cse\DOMManager\Handlers\DomNode\DomNodeListHandler;
use cse\DOMManager\Handlers\Nodes\NodeListHandler;
use cse\DOMManager\Nodes\NodeList;

class NodeListHandlerTest extends \Tests\BaseTestCase
{
    /** @var NodeListHandler $nodeListHandler */
    protected $nodeListHandler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->nodeListHandler = new NodeListHandler(new DomNodeHandler($this->xPath), new DomNodeListHandler());
    }

    /**
     * @param string $node_name
     * @param string $value
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider addTextProvider
     *
     * @throws \Exception
     */
    public function testAddText(string $node_name, string $value, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->nodeListHandler->addText($nodeList, $value);

        $this->assertEqualsNodeListContent($nodeList, $equals);
    }

    /**
     * @return array[]
     */
    public function addTextProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'value' => '',
                'equals' => [],
            ],
            [
                'node_name' => 'main',
                'value' => 'new text',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>new text</main>',
                ],
            ],
            [
                'node_name' => 'br',
                'value' => 'new text',
                'equals' => [
                    '<br>new text</br>',
                    '<br>new text</br>',
                ],
            ],
            [
                'node_name' => 'h1',
                'value' => 'new text',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheadernew text</h1>',
                ],
            ],
            [
                'node_name' => 'p',
                'value' => 'new text',
                'equals' => [
                    '<p><span class="text">First text</span>new text</p>',
                    '<p>Last textnew text</p>',
                    '<p>First descriptionnew text</p>',
                    '<p><span>Last description</span>new text</p>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $item_node
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider addListProvider
     *
     * @throws \Exception
     */
    public function testAddList(string $node_name, string $item_node, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeListHandler->addList(
                $this->getNodeListDocumentByElem($node_name),
                $this->getNodeListDocumentByElem($item_node, self::FILE_ITEM)
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function addListProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'item_node' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'br',
                'item_node' => 'hr',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
            [
                'node_name' => 'hr',
                'item_node' => 'span',
                'equals' => [
                    '<span class="header">new elem first</span>',
                ],
            ],
            [
                'node_name' => 'div',
                'item_node' => 'span',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                    '<span class="header">new elem first</span>',
                ],
            ],
            [
                'node_name' => 'p',
                'item_node' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p><span>Last description</span></p>',
                    '<p><span class="header">new elem first</span></p>',
                    '<p class="info">new elem last</p>',
                ],
            ],
            [
                'node_name' => 'main',
                'item_node' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                    '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
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
     * @dataProvider appendChildesProvider
     *
     * @throws \Exception
     */
    public function testAppendChildes(string $node_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeListHandler->appendChildes(
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
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><br/><p>Last text</p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div>',
                ],
            ],
            [
                'node_name' => 'h1',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></h1>',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    '<br><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></br>',
                    '<br><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></br>',
                ],
            ],
            [
                'node_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                    '<p>Last text<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                    '<p>First description<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                    '<p><span>Last description</span><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function testAppendChildesEmptyNodeList(): void
    {
        $nodeList = $this->getNodeListByFile();
        $this->assertEquals($this->nodeListHandler->appendChildes($nodeList, new NodeList()), $nodeList);
        $this->assertEquals($this->nodeListHandler->appendChildes(new NodeList(), $nodeList), $nodeList);
    }

    /**
     * @param string $node_name
     * @param string $attr_name
     * @param string|null $default_attr
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider attrProvider
     */
    public function testAttr(string $node_name, string $attr_name, ?string $default_attr, ?string $equals): void
    {
        $this->assertEquals(
            $this->nodeListHandler->attr(
                $this->getNodeListDocumentByElem($node_name),
                $attr_name,
                $default_attr
            ),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function attrProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'attr_name' => 'class',
                'default_attr' => null,
                'equals' => 'main',
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'role',
                'default_attr' => null,
                'equals' => 'main',
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'test',
                'default_attr' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'test',
                'default_attr' => 'default value',
                'equals' => 'default value',
            ],
            [
                'node_name' => 'img',
                'attr_name' => 'alt',
                'default_attr' => null,
                'equals' => 'content img',
            ],
            [
                'node_name' => 'img',
                'attr_name' => 'src',
                'default_attr' => null,
                'equals' => 'content_img.jpg',
            ],
            [
                'node_name' => 'div',
                'attr_name' => 'class',
                'default_attr' => null,
                'equals' => 'content' . PHP_EOL . 'description',
            ],
            [
                'node_name' => 'div',
                'attr_name' => 'class',
                'default_attr' => '',
                'equals' => 'content' . PHP_EOL . PHP_EOL . 'description',
            ],
            [
                'node_name' => 'span',
                'attr_name' => 'class',
                'default_attr' => null,
                'equals' => 'text',
            ],
            [
                'node_name' => 'span',
                'attr_name' => 'class',
                'default_attr' => 'default',
                'equals' => 'default' . PHP_EOL . 'text' . PHP_EOL . 'default',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider contentProvider
     */
    public function testContent(string $node_name, ?string $equals): void
    {
        $this->assertEquals($this->nodeListHandler->toString($this->getNodeListDocumentByElem($node_name)), $equals);
    }

    /**
     * @return array[]
     */
    public function contentProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'h1',
                'equals' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
            [
                'node_name' => 'hr',
                'equals' => '',
            ],
            [
                'node_name' => 'div',
                'equals' => '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>' . PHP_EOL
                    . '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>' . PHP_EOL
                    . '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
            ],
            [
                'node_name' => 'br',
                'equals' => '<br/>' . PHP_EOL . '<br/>',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $attr_name
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider hasAttrProvider
     */
    public function testHasAttr(string $node_name, string $attr_name, bool $equals): void
    {
        $this->assertEquals(
            $this->nodeListHandler->hasAttr($this->getNodeListDocumentByElem($node_name), $attr_name),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function hasAttrProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'attr_name' => 'class',
                'equals' => false,
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'class',
                'equals' => true,
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'role',
                'equals' => true,
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'test',
                'equals' => false,
            ],
            [
                'node_name' => 'div',
                'attr_name' => 'class',
                'equals' => false,
            ],
            [
                'node_name' => 'div[@class]',
                'attr_name' => 'class',
                'equals' => true,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider nameProvider
     */
    public function testName(string $node_name, ?string $equals): void
    {
        $this->assertEquals($this->nodeListHandler->name($this->getNodeListDocumentByElem($node_name)), $equals);
    }

    /**
     * @return array[]
     */
    public function nameProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'equals' => 'main',
            ],
            [
                'node_name' => 'h1',
                'equals' => 'h1',
            ],
            [
                'node_name' => 'hr',
                'equals' => '',
            ],
            [
                'node_name' => 'div',
                'equals' => 'div' . PHP_EOL . 'div' . PHP_EOL . 'div',
            ],
            [
                'node_name' => 'br',
                'equals' => 'br' . PHP_EOL . 'br',
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
            $this->nodeListHandler->remove($this->getNodeListDocumentByElem($node_name)),
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
                'equals' => null,
            ],
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"/>',
                ],
            ],
            [
                'node_name' => 'h1',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><em>Middle description</em><p><span>Last description</span></p></div></main>',
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
     * @dataProvider removeTextProvider
     *
     * @throws \Exception
     */
    public function testRemoveText(string $node_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->nodeListHandler->removeText($nodeList);
        $this->assertEqualsNodeListContent($nodeList, $equals);
    }

    /**
     * @return array[]
     */
    public function removeTextProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
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
                    '<h1><i class="icon"/><span>Header</span></h1>',
                ],
            ],
            [
                'node_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p/>',
                    '<p/>',
                    '<p><span>Last description</span></p>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $attr_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider removeAttrProvider
     *
     * @throws \Exception
     */
    public function testRemoveAttr(string $node_name, string $attr_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->nodeListHandler->removeAttr($nodeList, $attr_name);
        $this->assertEqualsNodeListContent($nodeList, $equals);
    }

    /**
     * @return array[]
     */
    public function removeAttrProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'attr_name' => '',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'test',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'class',
                'equals' => [
                    '<main role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'role',
                'equals' => [
                    '<main class="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'hr',
                'attr_name' => '',
                'equals' => null,
            ],
            [
                'node_name' => 'div',
                'attr_name' => 'class',
                'equals' => [
                    '<div><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
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
     * @dataProvider removeFirstProvider
     *
     * @throws \Exception
     */
    public function testRemoveFirst(string $node_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeListHandler->removeFirst($this->getNodeListDocumentByElem($node_name)),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function removeFirstProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'equals' => null,
            ],
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'h1',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $new_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider renameProvider
     *
     * @throws \Exception
     */
    public function testRename(string $node_name, string $new_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->nodeListHandler->rename($new_name, $nodeList);
        $this->assertEqualsNodeListContent($nodeList, $equals);
    }

    /**
     * @return array[]
     */
    public function renameProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'new_name' => 'div',
                'equals' => [
                    '<div class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></div>',
                ],
            ],
            [
                'node_name' => 'hr',
                'new_name' => '',
                'equals' => null,
            ],
            [
                'node_name' => 'h1',
                'new_name' => 'h2',
                'equals' => [
                    '<h2><i class="icon"/><span>Header</span>-subheader</h2>',
                ],
            ],
            [
                'node_name' => 'div',
                'new_name' => 'section',
                'equals' => [
                    '<section class="content"><section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section><br/><p>Last text</p></section>',
                    '<section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section>',
                    '<section class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></section>',
                ],
            ],
            [
                'node_name' => 'br',
                'new_name' => 'hr',
                'equals' => [
                    '<hr/>',
                    '<hr/>',
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
     * @dataProvider replaceProvider
     *
     * @throws \Exception
     */
    public function testReplace(string $node_name, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->nodeListHandler->replace(
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
                'equals' => [
                    '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
                ],
            ],
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'h1',
                'equals' => [
                    '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
                    '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
                    '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function testReplaceEmptyContent(): void
    {
        $nodeList = $this->getNodeListByFile();
        $this->assertEquals($this->nodeListHandler->replace($nodeList, new NodeList()), $nodeList);
    }

    /**
     * @param string $node_name
     * @param string $value
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider replaceTextProvider
     *
     * @throws \Exception
     */
    public function testReplaceText(string $node_name, string $value, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->nodeListHandler->replaceText($nodeList, $value);
        $this->assertEqualsNodeListContent($nodeList, $equals);
    }

    /**
     * @return array[]
     */
    public function replaceTextProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'value' => '',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'value' => 'new text',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>new text</main>',
                ],
            ],
            [
                'node_name' => 'br',
                'value' => 'new text',
                'equals' => [
                    '<br>new text</br>',
                    '<br>new text</br>',
                ],
            ],
            [
                'node_name' => 'h1',
                'value' => 'new text',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>new text</h1>',
                ],
            ],
            [
                'node_name' => 'p',
                'value' => 'new text',
                'equals' => [
                    '<p><span class="text">First text</span>new text</p>',
                    '<p>new text</p>',
                    '<p>new text</p>',
                    '<p><span>Last description</span>new text</p>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $attr_name
     * @param string $value
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider setAttrProvider
     *
     * @throws \Exception
     */
    public function testSetAttr(string $node_name, string $attr_name, string $value, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->nodeListHandler->setAttr($nodeList, $attr_name, $value);
        $this->assertEqualsNodeListContent($nodeList, $equals);
    }

    /**
     * @return array[]
     */
    public function setAttrProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'attr_name' => '',
                'value' => '',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'class',
                'value' => 'main-content',
                'equals' => [
                    '<main class="main-content" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'role',
                'value' => 'article',
                'equals' => [
                    '<main class="main" role="article"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'main',
                'attr_name' => 'data-value',
                'value' => '1',
                'equals' => [
                    '<main class="main" role="main" data-value="1"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'attr_name' => 'class',
                'value' => 'content _new',
                'equals' => [
                    '<div class="content _new"><div class="content _new"><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div class="content _new"><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="content _new" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'br',
                'attr_name' => 'class',
                'value' => 'nbsp',
                'equals' => [
                    '<br class="nbsp"/>',
                    '<br class="nbsp"/>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider textProvider
     */
    public function testText(string $node_name, ?string $equals): void
    {
        $this->assertEquals($this->nodeListHandler->text($this->getNodeListDocumentByElem($node_name)), $equals);
    }

    /**
     * @return array[]
     */
    public function textProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'equals' => '',
            ],
            [
                'node_name' => 'em',
                'equals' => 'Middle description',
            ],
            [
                'node_name' => 'br',
                'equals' => PHP_EOL,
            ],
            [
                'node_name' => 'h1',
                'equals' => 'Header-subheader',
            ],
            [
                'node_name' => 'p',
                'equals' => 'First text' . PHP_EOL . 'Last text' . PHP_EOL . 'First description' . PHP_EOL
                    . 'Last description',
            ],
            [
                'node_name' => 'main',
                'equals' => 'Header-subheaderFirst textLast textFirst descriptionMiddle descriptionLast description',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider typeProvider
     */
    public function testType(string $node_name, ?string $equals): void
    {
        $this->assertEquals($this->nodeListHandler->type($this->getNodeListDocumentByElem($node_name)), $equals);
    }

    /**
     * @return array[]
     */
    public function typeProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'equals' => '',
            ],
            [
                'node_name' => 'main',
                'equals' => '1',
            ],
            [
                'node_name' => 'div',
                'equals' => '1' . PHP_EOL . '1' . PHP_EOL . '1',
            ],
            [
                'node_name' => 'em',
                'equals' => '1',
            ],
            [
                'node_name' => 'br',
                'equals' => '1' . PHP_EOL . '1',
            ],
            [
                'node_name' => 'h1',
                'equals' => '1',
            ],
            [
                'node_name' => 'p',
                'equals' => '1' . PHP_EOL . '1' . PHP_EOL . '1' . PHP_EOL . '1',
            ],
        ];
    }
}
