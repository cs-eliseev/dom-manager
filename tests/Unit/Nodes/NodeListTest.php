<?php

declare(strict_types=1);

namespace Unit\Nodes;

class NodeListTest extends \Tests\BaseTestCase
{
    /**
     * @param string $node_name
     * @param int $count
     *
     * @return void
     *
     * @dataProvider countProvider
     */
    public function testCount(string $node_name, int $count): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->assertEquals($nodeList->count(), $count);
    }

    /**
     * @param string $node_name
     * @param int $count
     *
     * @return void
     *
     * @dataProvider countProvider
     */
    public function testExist(string $node_name, int $count): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->assertEquals($nodeList->exist(), $count != 0);
    }

    /**
     * @param string $node_name
     * @param int $count
     *
     * @return void
     *
     * @dataProvider countProvider
     */
    public function testEmpty(string $node_name, int $count): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->assertEquals($nodeList->isEmpty(), $count == 0);
    }

    /**
     * @return array[][]
     */
    public function countProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'count' => 1,
            ],
            [
                'node_name' => 'hr',
                'count' => 0,
            ],
            [
                'node_name' => 'div',
                'count' => 3,
            ],
            [
                'node_name' => 'br',
                'count' => 2,
            ],
            [
                'node_name' => 'p',
                'count' => 4,
            ],
            [
                'node_name' => 'h1',
                'count' => 1,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string|null $equal
     *
     * @return void
     *
     * @dataProvider popProvider
     */
    public function testPop(string $node_name, ?string $equal): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);

        $cnt = $nodeList->count();
        $content = $nodeList->pop();
        if (isset($content)) {
            $content = $content->ownerDocument->saveXML($content);
            $cnt -= 1;
        }

        $this->assertEquals($content, $equal);
        $this->assertEquals($nodeList->count(), $cnt);
    }

    /**
     * @return array[][]
     */
    public function popProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'equal' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'hr',
                'equal' => null,
            ],
            [
                'node_name' => 'div',
                'equal' => '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
            ],
            [
                'node_name' => 'br',
                'equal' => '<br/>',
            ],
            [
                'node_name' => 'p',
                'equal' => '<p><span class="text">First text</span></p>',
            ],
            [
                'node_name' => 'h1',
                'equal' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param int $position
     * @param string|null $equal
     *
     * @return void
     *
     * @dataProvider peekProvider
     */
    public function testPeek(string $node_name, int $position, ?string $equal): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);

        $cnt = $nodeList->count();
        $content = $nodeList->peek($position);
        if (isset($content)) {
            $content = $content->ownerDocument->saveXML($content);
        }

        $this->assertEquals($content, $equal);
        $this->assertEquals($nodeList->count(), $cnt);
    }

    /**
     * @return array[][]
     */
    public function peekProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'position' => 0,
                'equal' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'main',
                'position' => 1,
                'equal' => null,
            ],
            [
                'node_name' => 'hr',
                'position' => 0,
                'equal' => null,
            ],
            [
                'node_name' => 'div',
                'position' => 0,
                'equal' => '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
            ],
            [
                'node_name' => 'div',
                'position' => 1,
                'equal' => '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
            ],
            [
                'node_name' => 'div',
                'position' => 2,
                'equal' => '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
            ],
            [
                'node_name' => 'div',
                'position' => 3,
                'equal' => null,
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider listProvider
     *
     * @throws \Exception
     */
    public function testPull(string $node_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $this->assertEqualsArrayDomNodeContent($nodeList->pull(), $equals);
        $this->assertTrue($nodeList->isEmpty());
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider listProvider
     *
     * @throws \Exception
     */
    public function testAll(string $node_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $cnt = $nodeList->count();
        $this->assertEqualsArrayDomNodeContent($nodeList->all(), $equals);
        $this->assertEquals($cnt, $nodeList->count());
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider listProvider
     */
    public function testEach(string $node_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $nodeList->each(function ($domNode) use ($equals) {
            /** @var \DOMNode $domNode */
            $this->assertTrue(in_array($domNode->ownerDocument->saveXML($domNode), $equals));
        });
        $this->assertEquals($nodeList->count(), is_null($equals) ? 0 : count($equals));
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider listProvider
     *
     * @throws \Exception
     */
    public function testCopy(string $node_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $copyNodeList = $nodeList->copy();

        $this->assertEquals($nodeList->count(), $copyNodeList->count());
        $this->assertEquals($nodeList, $copyNodeList);
        $this->assertEqualsNodeListContent($copyNodeList, $equals);

        $nodeList->push(new \DOMNode());
        $this->assertNotEquals($nodeList->count(), $copyNodeList->count());
        $this->assertNotEquals($nodeList, $copyNodeList);
        $this->assertEqualsNodeListContent($copyNodeList, $equals);
    }

    /**
     * @param string $node_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider listProvider
     *
     * @throws \Exception
     */
    public function testNew(string $node_name, ?array $equals): void
    {
        $nodeList = $this->getNodeListDocumentByElem($node_name);
        $copyNodeList = $nodeList->new();
        if (is_null($equals)) {
            $this->assertEquals($nodeList->count(), $copyNodeList->count());
            $this->assertEquals($nodeList, $copyNodeList);
        } else {
            $this->assertNotEquals($nodeList->count(), $copyNodeList->count());
            $this->assertNotEquals($nodeList, $copyNodeList);
        }

        $this->assertTrue($copyNodeList->isEmpty());
    }

    /**
     * @return array[][]
     */
    public function listProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
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
                    '<p><span class="text">First text</span></p>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p><span>Last description</span></p>',
                ]
            ],
            [
                'node_name' => 'h1',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                ],
            ],
        ];
    }

    /**
     * @param string $node_name
     * @param string $node_name_replace
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider replaceProvider
     *
     * @throws \Exception
     */
    public function testReplace(string $node_name, string $node_name_replace, ?array $equals): void
    {
        $this->assertEqualsNodeListContent(
            $this->getNodeListDocumentByElem($node_name)->replace($this->getNodeListDocumentByElem($node_name_replace)),
            $equals
        );
    }

    /**
     * @return array[][]
     */
    public function replaceProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'node_name_replace' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'hr',
                'node_name_replace' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'p',
                'node_name_replace' => 'div',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'node_name_replace' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p><span>Last description</span></p>',
                ]
            ],
        ];
    }
}
