<?php

declare(strict_types=1);

namespace Unit\Handlers\DomNode;

use cse\DOMManager\Handlers\DomNode\DomNodeHandler;
use cse\DOMManager\Handlers\DomNode\XPathHandler;

class DomNodeHandlerTest extends \Tests\BaseTestCase
{
    /** @var DomNodeHandler $domNode */
    private $domNode;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->domNode = new DomNodeHandler(new XPathHandler());
    }

    /**
     * @param string $parent
     * @param string $child
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider appendChildProvider
     */
    public function testAppendChild(string $parent, string $child, string $equals): void
    {
        $domDocument = $this->getDocumentByFileName();

        $parentNode = $domDocument->getElementsByTagName($parent)->item(0);
        $this->domNode->appendChild(
            $parentNode,
            $this->getDocumentByFileName(self::FILE_ITEM)->getElementsByTagName($child)->item(0)
        );

        $this->assertEquals($domDocument->saveXML($domDocument->documentElement), $equals);
    }

    /**
     * @return array[]
     */
    public function appendChildProvider(): array
    {
        return [
            [
                'parent' => 'p',
                'child' => 'span',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span><span class="header">new elem first</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'parent' => 'div',
                'child' => 'p',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p><p><span class="header">new elem first</span></p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'parent' => 'main',
                'child' => 'div',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></main>',
            ],
            [
                'parent' => 'h1',
                'child' => 'div',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $find_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider closestProvider
     */
    public function testClosest(string $node_name, string $find_name, ?string $equals): void
    {
        $domDocument = $this->getDocumentByFileName();

        $node = $domDocument->getElementsByTagName($node_name)->item(0);
        $parentNode = $this->domNode->closest($find_name, $node);
        if (isset($parentNode)) {
            $parentNode = $domDocument->saveXML($parentNode);
        }

        $this->assertEquals($parentNode, $equals);
    }

    /**
     * @return array[]
     */
    public function closestProvider(): array
    {
        return [
            [
                'node_name' => 'span',
                'find_name' => 'h1',
                'equals' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
            [
                'node_name' => 'span',
                'find_name' => 'div',
                'equals' => '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
            ],
            [
                'node_name' => 'span',
                'find_name' => 'main',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'span',
                'find_name' => 'br',
                'equals' => null,
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
        $this->assertEquals(
            $this->domNode->content($this->getDocumentByFileName()->getElementsByTagName($node_name)->item(0)),
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
                'node_name' => 'h1',
                'equals' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
            [
                'node_name' => 'span',
                'equals' => '<span>Header</span>',
            ],
            [
                'node_name' => 'main',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'div',
                'equals' => '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
            ],
        ];
    }

    /**
     * @param string $query
     * @param int $count
     *
     * @return void
     *
     * @dataProvider filterProvider
     */
    public function testFilter(string $query, int $count): void
    {
        $this->assertEquals(
            $this->domNode->filter($query, $this->getDocumentByFileName()->documentElement)->count(),
            $count
        );
    }

    /**
     * @return array[]
     */
    public function filterProvider(): array
    {
        return [
            [
                'query' => 'h1',
                'count' => 1,
            ],
            [
                'query' => '*/*/h1',
                'count' => 1,
            ],
            [
                'query' => 'span',
                'count' => 3,
            ],
            [
                'query' => '//p/span',
                'count' => 2,
            ],
            [
                'query' => 'p',
                'count' => 4,
            ],
            [
                'query' => '//p',
                'count' => 4,
            ],
            [
                'query' => 'br',
                'count' => 2,
            ],
            [
                'query' => '//div/br',
                'count' => 2,
            ],
            [
                'query' => 'hr',
                'count' => 0,
            ],
            [
                'query' => '//*[@src="content_img.jpg"]',
                'count' => 1,
            ],
        ];
    }

    /**
     * @param string $node_name
     *
     * @return void
     *
     * @dataProvider mainParentProvider
     */
    public function testMainParent(string $node_name): void
    {
        $this->assertEquals(
            $this->domNode->rootElement($this->getDocumentByFileName()->getElementsByTagName($node_name)->item(0))->nodeName,
            'main'
        );
    }

    /**
     * @return array[]
     */
    public function mainParentProvider(): array
    {
        return [
            [
                'node_name' => 'i',
            ],
            [
                'node_name' => 'p',
            ],
            [
                'node_name' => 'div',
            ],
            [
                'node_name' => 'main',
            ],
            [
                'node_name' => 'img',
            ],
            [
                'node_name' => 'br',
            ],
            [
                'node_name' => 'span',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider parentProvider
     */
    public function testParent(string $node_name, ?string $equals): void
    {
        $domDocument = $this->getDocumentByFileName();
        $node = $this->domNode->parentElement($domDocument->getElementsByTagName($node_name)->item(0));
        if (isset($equals)) {
            $node = $domDocument->saveXML($node);
        }

        $this->assertEquals($node, $equals);
    }

    /**
     * @return array[]
     */
    public function parentProvider(): array
    {
        return [
            [
                'node_name' => 'i',
                'equals' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
            [
                'node_name' => 'p',
                'equals' => '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
            ],
            [
                'node_name' => 'div',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'main',
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param bool $result_parent
     *
     * @return void
     *
     * @dataProvider isElemProvider
     */
    public function testIsElem(string $node_name, bool $result_parent): void
    {
        $this->assertEquals(
            $this->domNode->isElem($this->getDocumentByFileName()->getElementsByTagName($node_name)->item(0)->parentNode),
            $result_parent
        );
    }

    /**
     * @return array[]
     */
    public function isElemProvider(): array
    {
        return [
            [
                'node_name' => 'div',
                'result_parent' => true,
            ],
            [
                'node_name' => 'main',
                'result_parent' => false,
            ],
        ];
    }

    /**
     * @param \DOMNode $node
     * @param bool $is_text
     *
     * @return void
     *
     * @dataProvider isTextProvider
     */
    public function testIsText(\DOMNode $node, bool $is_text): void
    {
        $this->assertEquals($this->domNode->isText($node), $is_text);
    }

    /**
     * @return array[]
     */
    public function isTextProvider(): array
    {
        return [
            [
                'node' => new \DOMNode(),
                'is_text' => false,
            ],
            [
                'node' => new \DOMText(),
                'is_text' => true,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider removeProvider
     */
    public function testRemove(string $node_name, ?string $equals): void
    {
        $domDocument = $this->getDocumentByFileName();

        $node = $domDocument->getElementsByTagName($node_name)->item(0);
        $this->domNode->remove($node);

        $this->assertEquals($domDocument->saveXML($node->ownerDocument->documentElement), $equals);
    }

    /**
     * @return array[]
     */
    public function removeProvider(): array
    {
        return [
            [
                'node_name' => 'span',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'div',
                'equals' => '<main class="main" role="main"><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'p',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'main',
                'equals' => '<?xml version="1.0"?>' . PHP_EOL,
            ],
        ];
    }

    /**
     * @param string $rename_node
     * @param string $new_name
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider renameProvider
     */
    public function testRename(string $rename_node, string $new_name, string $equals): void
    {
        $domDocument = $this->getDocumentByFileName();

        $node = $domDocument->getElementsByTagName($rename_node)->item(0);
        $this->domNode->rename($new_name, $node);

        $this->assertEquals($domDocument->saveXML($node->ownerDocument->documentElement), $equals);
    }

    /**
     * @return array[]
     */
    public function renameProvider(): array
    {
        return [
            [
                'rename_node' => 'div',
                'new_name' => 'section',
                'equals' => '<main class="main" role="main"><section class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></section><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'rename_node' => 'p',
                'new_name' => 'span',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><span><span class="text">First text</span></span></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'rename_node' => 'span',
                'new_name' => 'b',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><b>Header</b>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'rename_node' => 'main',
                'new_name' => 'div',
                'equals' => '<div class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></div>'
            ],
            [
                'rename_node' => 'h1',
                'new_name' => 'h2',
                'equals' => '<main class="main" role="main"><div class="content"><div><h2><i class="icon"/><span>Header</span>-subheader</h2><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>'
            ],
        ];
    }

    /**
     * @param string $replace_node
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider replaceProvider
     */
    public function testReplace(string $replace_node, string $equals): void
    {
        $domDocument = $this->getDocumentByFileName();

        $oldNode = $domDocument->getElementsByTagName($replace_node)->item(0);
        $this->domNode->replace(
            $oldNode,
            $this->getDocumentByFileName(self::FILE_ITEM)->documentElement
        );

        $this->assertEquals($domDocument->saveXML($domDocument->documentElement), $equals);
    }

    /**
     * @return array[]
     */
    public function replaceProvider(): array
    {
        return [
            [
                'replace_node' => 'div',
                'equals' => '<main class="main" role="main"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'replace_node' => 'main',
                'equals' => '<div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>',
            ],
            [
                'replace_node' => 'p',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'replace_node' => 'span',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
        ];
    }
}
