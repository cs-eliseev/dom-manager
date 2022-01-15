<?php

declare(strict_types=1);

namespace Unit\Nodes;

use cse\DOMManager\Nodes\Nodes;

class NodesTest extends \Tests\BaseTestCase
{
    /** @var Nodes $nodes */
    protected $nodes;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->nodes = $this->domManager->create($this->getDocumentByFileName());
    }

    /**
     * @param string $elem_name
     * @param string $text
     * @param array $equals
     *
     * @return void
     *
     * @dataProvider addTextProvider
     *
     * @throws \Exception
     */
    public function testAddText(string $elem_name, string $text, array $equals): void
    {
        $this->nodes->find($elem_name)->addText($text);
        $this->assertEqualsNodesContent($this->nodes, $equals);
    }

    /**
     * @return array[]
     */
    public function addTextProvider(): array
    {
        return [
            [
                'elem_name' => 'i',
                'text' => 'new text',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon">new text</i><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'elem_name' => 'div',
                'text' => 'new text',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p>new text</div><br/><p>Last text</p>new text</div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p>new text</div></main>',
                ],
            ],
            [
                'elem_name' => 'div/div',
                'text' => 'new text',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p>new text</div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array $equals
     *
     * @return void
     *
     * @dataProvider appendChildProvider
     *
     * @throws \Exception
     */
    public function testAppendChild(string $elem_name, ?string $find_name, array $equals): void
    {
        $this->nodes->find($elem_name)->appendChild($this->getFileContent(self::FILE_ITEM), $find_name);
        $this->assertEqualsNodesContent($this->nodes, $equals);
    }

    /**
     * @return array[]
     */
    public function appendChildProvider(): array
    {
        return [
            [
                'elem_name' => 'i',
                'find_name' => null,
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></i><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => null,
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><br/><p>Last text</p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div></main>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'elem_name' => 'div/div',
                'find_name' => null,
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'i',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></i><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string $attr
     * @param string|null $default
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider attrProvider
     */
    public function testAttr(string $elem_name, string $attr, ?string $default, ?string $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->attr($attr, $default), $equals);
    }

    /**
     * @return array[]
     */
    public function attrProvider(): array
    {
        return [
            [
                'elem_name' => 'i',
                'attr' => 'class',
                'default' => null,
                'equals' => 'icon',
            ],
            [
                'elem_name' => 'i',
                'attr' => 'role',
                'default' => null,
                'equals' => null,
            ],
            [
                'elem_name' => 'i',
                'attr' => 'role',
                'default' => 'default',
                'equals' => 'default',
            ],
            [
                'elem_name' => 'span',
                'attr' => 'role',
                'default' => 'default',
                'equals' => 'default' . PHP_EOL . 'default' . PHP_EOL . 'default',
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider childesProvider
     *
     * @throws \Exception
     */
    public function testChildes(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->childes($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function childesProvider(): array
    {
        return [
            [
                'elem_name' => 'div',
                'find_name' => null,
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
                'elem_name' => 'div/div',
                'find_name' => null,
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<img src="content_img.jpg" alt="content img"/>',
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'div',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<img src="content_img.jpg" alt="content img"/>',
                    '<p><span class="text">First text</span></p>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider closestProvider
     *
     * @throws \Exception
     */
    public function testClosest(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->closest($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function closestProvider(): array
    {
        return [
            [
                'elem_name' => 'div',
                'find_name' => null,
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'elem_name' => 'div/div',
                'find_name' => null,
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'div',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'main',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'section',
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider parentProvider
     *
     * @throws \Exception
     */
    public function testParent(string $elem_name, ?array $equals): void
    {
        if ($elem_name == 'main') {
            $nodes = $this->nodes;
        } else {
            $nodes = $this->nodes->find($elem_name);
        }

        $result = $nodes->parent();

        $this->assertEqualsNodesContent($result, $equals);
    }

    /**
     * @return array[]
     */
    public function parentProvider(): array
    {
        return [
            [
                'elem_name' => 'i',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                ],
            ],
            [
                'elem_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'elem_name' => 'div/div',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function testParentEmptyContent(): void
    {
        $this->assertTrue($this->domManager->create(new \DOMNode())->parent()->notExist());
    }

    /**
     * @param string $elem_name
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider isElemProvider
     */
    public function testIsElem(string $elem_name, bool $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->isElem(), $equals);
    }

    /**
     * @return array[]
     */
    public function isElemProvider(): array
    {
        return [
            [
                'elem_name' => 'i',
                'equals' => true,
            ],
            [
                'elem_name' => 'img',
                'equals' => true,
            ],
            [
                'elem_name' => 'br',
                'equals' => false,
            ],
            [
                'elem_name' => 'span',
                'equals' => false,
            ],
            [
                'elem_name' => '//h1/span',
                'equals' => true,
            ],
            [
                'elem_name' => '//p/span',
                'equals' => false,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider isListProvider
     */
    public function testIsList(string $elem_name, bool $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->isList(), $equals);
    }

    /**
     * @return array[]
     */
    public function isListProvider(): array
    {
        return [
            [
                'elem_name' => 'i',
                'equals' => false,
            ],
            [
                'elem_name' => 'img',
                'equals' => false,
            ],
            [
                'elem_name' => 'br',
                'equals' => true,
            ],
            [
                'elem_name' => 'span',
                'equals' => true,
            ],
            [
                'elem_name' => '//h1/span',
                'equals' => false,
            ],
            [
                'elem_name' => '//p/span',
                'equals' => true,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param int $equals
     *
     * @return void
     *
     * @dataProvider countProvider
     */
    public function testCount(string $elem_name, ?string $find_name, int $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->count($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function countProvider(): array
    {
        return [
            [
                'elem_name' => 'h1',
                'find_name' => null,
                'equals' => 1,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'h1',
                'equals' => 2,
            ],
            [
                'elem_name' => 'div/div',
                'find_name' => 'h1',
                'equals' => 1,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'div/h1',
                'equals' => 1,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param int $position
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider getNodeByPositionProvider
     */
    public function testGetNodeByPosition(string $elem_name, int $position, ?array $equals): void
    {
        $result = $this->nodes->find($elem_name)->getNodeByPosition($position);
        $this->assertTagsDomNodes(is_null($result) ? null : [$result], $equals);
    }

    /**
     * @return array[]
     */
    public function getNodeByPositionProvider(): array
    {
        return [
            [
                'elem_name' => 'div',
                'position' => 0,
                'equals' => [
                    'div'
                ],
            ],
            [
                'elem_name' => 'div',
                'position' => 1,
                'equals' => [
                    'div'
                ],
            ],
            [
                'elem_name' => 'div',
                'position' => 2,
                'equals' => [
                    'div'
                ],
            ],
            [
                'elem_name' => 'div',
                'position' => 3,
                'equals' => null,
            ],
            [
                'elem_name' => 'div/div',
                'position' => 0,
                'equals' => [
                    'div'
                ],
            ],
            [
                'elem_name' => 'div/div',
                'position' => 1,
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param int $position
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider findNodeByPositionProvider
     */
    public function testFindNodeByPosition(string $elem_name, int $position, ?string $find_name, ?array $equals): void
    {
        $result = $this->nodes->find($elem_name)->findNodeByPosition($position, $find_name);
        $this->assertTagsDomNodes(is_null($result) ? null : $result, $equals);
    }

    /**
     * @return array[]
     */
    public function findNodeByPositionProvider(): array
    {
        return [
            [
                'elem_name' => 'div',
                'position' => 0,
                'find_name' => 'div',
                'equals' => [
                    'div'
                ],
            ],
            [
                'elem_name' => 'div',
                'position' => 1,
                'find_name' => 'div',
                'equals' => [],
            ],
            [
                'elem_name' => 'div/div',
                'position' => 0,
                'find_name' => 'div',
                'equals' => [],
            ],
            [
                'elem_name' => 'div',
                'position' => 0,
                'find_name' => 'p',
                'equals' => [
                    'p',
                    'p',
                    'p',
                ],
            ],
            [
                'elem_name' => 'div',
                'position' => 1,
                'find_name' => 'p',
                'equals' => [
                    'p',
                    'p',
                ],
            ],
            [
                'elem_name' => 'div/div',
                'position' => 0,
                'find_name' => 'p',
                'equals' => [
                    'p',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider contentProvider
     */
    public function testContent(string $elem_name, ?string $find_name, string $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->toString($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function contentProvider(): array
    {
        return [
            [
                'elem_name' => 'h1',
                'find_name' => null,
                'equals' => '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
            ],
            [
                'elem_name' => 'i',
                'find_name' => null,
                'equals' => '<i class="icon"/>',
            ],
            [
                'elem_name' => 'h1',
                'find_name' => 'i',
                'equals' => '<i class="icon"/>',
            ],
            [
                'elem_name' => '//h1/i',
                'find_name' => null,
                'equals' => '<i class="icon"/>',
            ],
            [
                'elem_name' => '//div/h1',
                'find_name' => 'i',
                'equals' => '<i class="icon"/>',
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'h1/i',
                'equals' => '<i class="icon"/>',
            ],
            [
                'elem_name' => 'p',
                'find_name' => null,
                'equals' => '<p><span class="text">First text</span></p>' . PHP_EOL
                    . '<p>Last text</p>' . PHP_EOL . '<p>First description</p>' . PHP_EOL
                    . '<p><span>Last description</span></p>',
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'p',
                'equals' => '<p><span class="text">First text</span></p>' . PHP_EOL
                    . '<p>Last text</p>' . PHP_EOL . '<p><span class="text">First text</span></p>' . PHP_EOL
                    . '<p>First description</p>' . PHP_EOL . '<p><span>Last description</span></p>',
            ],
            [
                'elem_name' => '//div/p',
                'find_name' => null,
                'equals' => '<p><span class="text">First text</span></p>' . PHP_EOL
                    . '<p>Last text</p>' . PHP_EOL . '<p>First description</p>' . PHP_EOL
                    . '<p><span>Last description</span></p>',
            ],
            [
                'elem_name' => '//div/div',
                'find_name' => 'p',
                'equals' => '<p><span class="text">First text</span></p>',
            ],
            [
                'elem_name' => 'hr',
                'find_name' => null,
                'equals' => '',
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'hr',
                'equals' => '',
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider existProvider
     */
    public function testExist(string $elem_name, ?string $find_name, bool $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->exist($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function existProvider(): array
    {
        return [
            [
                'elem_name' => 'h1',
                'find_name' => null,
                'equals' => true,
            ],
            [
                'elem_name' => 'i',
                'find_name' => null,
                'equals' => true,
            ],
            [
                'elem_name' => 'h1',
                'find_name' => 'i',
                'equals' => true,
            ],
            [
                'elem_name' => '//h1/i',
                'find_name' => null,
                'equals' => true,
            ],
            [
                'elem_name' => '//div/h1',
                'find_name' => 'i',
                'equals' => true,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'h1/i',
                'equals' => true,
            ],
            [
                'elem_name' => 'span',
                'find_name' => 'i',
                'equals' => false,
            ],
            [
                'elem_name' => 'p',
                'find_name' => null,
                'equals' => true,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'p',
                'equals' => true,
            ],
            [
                'elem_name' => '//div/p',
                'find_name' => null,
                'equals' => true,
            ],
            [
                'elem_name' => '//div/div',
                'find_name' => 'p',
                'equals' => true,
            ],
            [
                'elem_name' => 'hr',
                'find_name' => null,
                'equals' => false,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'hr',
                'equals' => false,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider notExistProvider
     */
    public function testNotExist(string $elem_name, ?string $find_name, bool $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->notExist($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function notExistProvider(): array
    {
        return [
            [
                'elem_name' => 'h1',
                'find_name' => null,
                'equals' => false,
            ],
            [
                'elem_name' => 'i',
                'find_name' => null,
                'equals' => false,
            ],
            [
                'elem_name' => 'h1',
                'find_name' => 'b',
                'equals' => true,
            ],
            [
                'elem_name' => '//h1/i',
                'find_name' => null,
                'equals' => false,
            ],
            [
                'elem_name' => '//div/h1',
                'find_name' => 'i',
                'equals' => false,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'h1/b',
                'equals' => true,
            ],
            [
                'elem_name' => 'span',
                'find_name' => 'i',
                'equals' => true,
            ],
            [
                'elem_name' => 'p',
                'find_name' => null,
                'equals' => false,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'p',
                'equals' => false,
            ],
            [
                'elem_name' => '//div/p',
                'find_name' => null,
                'equals' => false,
            ],
            [
                'elem_name' => '//div/div',
                'find_name' => 'p',
                'equals' => false,
            ],
            [
                'elem_name' => 'hr',
                'find_name' => null,
                'equals' => true,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'hr',
                'equals' => true,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider firstProvider
     *
     * @throws \Exception
     */
    public function testFirst(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->first($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function firstProvider(): array
    {
        return [
            [
                'elem_name' => 'p',
                'find_name' => null,
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p><span class="text">First text</span></p>',
                    '<p>First description</p>',
                ],
            ],
            [
                'elem_name' => '//div/p',
                'find_name' => null,
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => '//div/div',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => 'hr',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'hr',
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider lastProvider
     *
     * @throws \Exception
     */
    public function testLast(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->last($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function lastProvider(): array
    {
        return [
            [
                'elem_name' => 'p',
                'find_name' => null,
                'equals' => [
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p>Last text</p>',
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'elem_name' => '//div/p',
                'find_name' => null,
                'equals' => [
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'elem_name' => '//div/div',
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => 'hr',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'hr',
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param int $position
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider getByPositionProvider
     *
     * @throws \Exception
     */
    public function testGetByPosition(string $elem_name, int $position, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->getByPosition($position, $find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function getByPositionProvider(): array
    {
        return [
            [
                'elem_name' => 'p',
                'position' => 0,
                'find_name' => null,
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => 'div',
                'position' => 0,
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                    '<p><span class="text">First text</span></p>',
                    '<p>First description</p>',
                ],
            ],
            [
                'elem_name' => '//div/p',
                'position' => 0,
                'find_name' => null,
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => '//div/div',
                'position' => 0,
                'find_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span></p>',
                ],
            ],
            [
                'elem_name' => 'hr',
                'position' => 0,
                'find_name' => null,
                'equals' => null,
            ],
            [
                'elem_name' => 'div',
                'position' => 0,
                'find_name' => 'hr',
                'equals' => null,
            ],


            [
                'elem_name' => 'p',
                'position' => 1,
                'find_name' => null,
                'equals' => [
                    '<p>Last text</p>',
                ],
            ],
            [
                'elem_name' => 'div',
                'position' => 1,
                'find_name' => 'p',
                'equals' => [
                    '<p>Last text</p>',
                    '<p><span>Last description</span></p>',
                ],
            ],
            [
                'elem_name' => '//div/p',
                'position' => 1,
                'find_name' => null,
                'equals' => [
                    '<p>Last text</p>',
                ],
            ],
            [
                'elem_name' => '//div/div',
                'position' => 1,
                'find_name' => 'p',
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider firstChildProvider
     *
     * @throws \Exception
     */
    public function testFirstChild(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->firstChild($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function firstChildProvider(): array
    {
        return [
            [
                'elem_name' => 'h1',
                'find_name' => null,
                'equals' => [
                    '<i class="icon"/>',
                ],
            ],
            [
                'elem_name' => 'p',
                'find_name' => null,
                'equals' => [
                    '<span class="text">First text</span>',
                    '<span>Last description</span>',
                ],
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'p',
                'equals' => [
                    '<span class="text">First text</span>',
                    '<span class="text">First text</span>',
                    '<span>Last description</span>',
                ],
            ],
            [
                'elem_name' => '//div/p',
                'find_name' => null,
                'equals' => [
                    '<span class="text">First text</span>',
                    '<span>Last description</span>',
                ],
            ],
            [
                'elem_name' => '//div/div',
                'find_name' => 'p',
                'equals' => [
                    '<span class="text">First text</span>',
                ],
            ],
            [
                'elem_name' => 'hr',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'elem_name' => 'div',
                'find_name' => 'hr',
                'equals' => null,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string $attr_name
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider hasAttrProvider
     */
    public function testHasAttr(string $elem_name, string $attr_name, bool $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->hasAttr($attr_name), $equals);
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
                'node_name' => 'img',
                'attr_name' => 'alt',
                'equals' => true,
            ],
            [
                'node_name' => 'img',
                'attr_name' => 'src',
                'equals' => true,
            ],
            [
                'node_name' => 'img',
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
     * @param $elem
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider isDomCommentProvider
     */
    public function testIsDomComment($elem, bool $equals): void
    {
        $this->assertEquals($this->domManager->create($elem)->isDomComment(), $equals);
    }

    /**
     * @return array[]
     */
    public function isDomCommentProvider(): array
    {
        return [
            [
                'elem' => new \DOMComment(),
                'equals' => true,
            ],
            [
                'elem' => new \DOMNode(),
                'equals' => false,
            ],
        ];
    }

    /**
     * @param $elem
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider isDomNodeProvider
     */
    public function testIsDomNode($elem, bool $equals): void
    {
        $this->assertEquals($this->domManager->create($elem)->isDomText(), $equals);
    }

    /**
     * @return array[]
     */
    public function isDomNodeProvider(): array
    {
        return [
            [
                'elem' => new \DOMText(),
                'equals' => true,
            ],
            [
                'elem' => $this->getDocumentByFileName(),
                'equals' => false,
            ],
        ];
    }

    /**
     * @param $elem
     * @param bool $equals
     *
     * @return void
     *
     * @dataProvider isDomElementProvider
     */
    public function testIsDomElement($elem, bool $equals): void
    {
        $this->assertEquals($this->domManager->create($elem)->isDomElement(), $equals);
    }

    /**
     * @return array[]
     */
    public function isDomElementProvider(): array
    {
        return [
            [
                'elem' => new \DOMElement('test'),
                'equals' => true,
            ],
            [
                'elem' => new \DOMNode(),
                'equals' => false,
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider mainParentProvider
     *
     * @throws \Exception
     */
    public function testMainParent(string $elem_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->root(), $equals);
    }

    /**
     * @return array[]
     */
    public function mainParentProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'img',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'em',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
            [
                'node_name' => 'div[@class]',
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider listProvider
     */
    public function testList(string $elem_name, ?array $equals): void
    {
        $this->assertTagsDomNodes($this->nodes->find($elem_name)->toArray(), $equals);
    }

    /**
     * @return array[]
     */
    public function listProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'equals' => [],
            ],
            [
                'node_name' => 'img',
                'equals' => [
                    'img',
                ],
            ],
            [
                'node_name' => 'em',
                'equals' => [
                    'em',
                ],
            ],
            [
                'node_name' => 'br',
                'equals' => [
                    'br',
                    'br',
                ],
            ],
            [
                'node_name' => 'div',
                'equals' => [
                    'div',
                    'div',
                    'div',
                ],
            ],
            [
                'node_name' => 'div[@class]',
                'equals' => [
                    'div',
                    'div',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $equals
     *
     * @return void
     *
     * @dataProvider nameProvider
     */
    public function testName(string $elem_name, ?string $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->name(), $equals);
    }

    /**
     * @return array[]
     */
    public function nameProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'equals' => null,
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
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider removeProvider
     *
     * @throws \Exception
     */
    public function testRemove(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->remove($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function removeProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'h1',
                'find_name' => null,
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>'
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
                'node_name' => 'p',
                'find_name' => null,
                'equals' => [
                    '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/></div><br/></div><div class="description" role="contentinfo"><br/><em>Middle description</em></div></main>',
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
        ];
    }

    /**
     * @param string $elem_name
     * @param string $attr_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider removeAttrProvider
     *
     * @throws \Exception
     */
    public function testRemoveAttr(string $elem_name, string $attr_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->removeAttr($attr_name), $equals);
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
                'equals' => null,
            ],
            [
                'node_name' => 'hr',
                'attr_name' => '',
                'equals' => null,
            ],
            [
                'node_name' => 'div',
                'attr_name' => '',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'div',
                'attr_name' => 'test',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
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
            [
                'node_name' => 'div',
                'attr_name' => 'role',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'i',
                'attr_name' => 'class',
                'equals' => [
                    '<i/>',
                ],
            ],
            [
                'node_name' => 'br',
                'attr_name' => 'class',
                'equals' => [
                    '<br/>',
                    '<br/>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider removeChildesProvider
     *
     * @throws \Exception
     */
    public function testRemoveChildes(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->removeChildes($find_name), $equals);
    }

    /**
     * @return array[]
     */
    public function removeChildesProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'h1',
                'find_name' => null,
                'equals' => [
                    '<h1>-subheader</h1>'
                ],
            ],
            [
                'node_name' => 'h1',
                'find_name' => 'i',
                'equals' => [
                    '<h1><span>Header</span>-subheader</h1>'
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
                'node_name' => 'p',
                'find_name' => null,
                'equals' => [
                    '<p/>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p/>',

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
        ];
    }

    /**
     * @param string $elem_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider removeTextProvider
     *
     * @throws \Exception
     */
    public function testRemoveText(string $elem_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->removeText(), $equals);
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
                'equals' => null,
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
     * @param string $elem_name
     * @param string $new_name
     * @param string|null $old_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider renameProvider
     *
     * @throws \Exception
     */
    public function testRename(string $elem_name, string $new_name, ?string $old_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->rename($new_name, $old_name), $equals);
    }

    /**
     * @return array[]
     */
    public function renameProvider(): array
    {
        return [
            [
                'node_name' => 'hr',
                'new_name' => 'b',
                'old_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'main',
                'new_name' => 'b',
                'old_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'br',
                'new_name' => 'b',
                'old_name' => null,
                'equals' => [
                    '<b/>',
                    '<b/>',
                ],
            ],
            [
                'node_name' => 'div',
                'new_name' => 'b',
                'old_name' => 'br',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><b/><p>Last text</p></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><b/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'h1',
                'new_name' => 'b',
                'old_name' => null,
                'equals' => [
                    '<b><i class="icon"/><span>Header</span>-subheader</b>',
                ],
            ],
            [
                'node_name' => 'div',
                'new_name' => 'b',
                'old_name' => 'h1',
                'equals' => [
                    '<div class="content"><div><b><i class="icon"/><span>Header</span>-subheader</b><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div><b><i class="icon"/><span>Header</span>-subheader</b><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
            [
                'node_name' => 'p',
                'new_name' => 'b',
                'old_name' => null,
                'equals' => [
                    '<b><span class="text">First text</span></b>',
                    '<b>Last text</b>',
                    '<b>First description</b>',
                    '<b><span>Last description</span></b>',
                ],
            ],
            [
                'node_name' => 'div',
                'new_name' => 'b',
                'old_name' => 'p',
                'equals' => [
                    '<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><b><span class="text">First text</span></b></div><br/><b>Last text</b></div>',
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><b><span class="text">First text</span></b></div>',
                    '<div class="description" role="contentinfo"><b>First description</b><br/><em>Middle description</em><b><span>Last description</span></b></div>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider replaceProvider
     */
    public function testReplace(string $elem_name, ?string $find_name, string $equals): void
    {
        $this->assertEquals(
            $this->nodes->find($elem_name)->replace(
                $this->getFileContent(self::FILE_ITEM),
                $find_name
            )->toString(),
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
                'find_name' => null,
                'equals' => '',
            ],
            [
                'node_name' => 'hr',
                'find_name' => null,
                'equals' => '',
            ],
            [
                'node_name' => 'div',
                'find_name' => 'hr',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'br',
                'find_name' => null,
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'div',
                'find_name' => 'br',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'i',
                'find_name' => null,
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'h1',
                'find_name' => 'i',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'div',
                'find_name' => '//h1/i',
                'equals' => '<main class="main" role="main"><div class="content"><div><h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>',
            ],
            [
                'node_name' => 'div',
                'find_name' => null,
                'equals' => '<main class="main" role="main"><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></main>',
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string|null $find_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider replaceChildesProvider
     *
     * @throws \Exception
     */
    public function testReplaceChildes(string $elem_name, ?string $find_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent(
            $this->nodes->find($elem_name)->replaceChildes($this->getFileContent(self::FILE_ITEM), $find_name),
            $equals
        );
    }

    /**
     * @return array[]
     */
    public function replaceChildesProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'hr',
                'find_name' => null,
                'equals' => null,
            ],
            [
                'node_name' => 'h1',
                'find_name' => null,
                'equals' => [
                    '<h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>-subheader</h1>',
                ],
            ],
            [
                'node_name' => '//div/h1',
                'find_name' => null,
                'equals' => [
                    '<h1><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'h1',
                'find_name' => 'span',
                'equals' => [
                    '<h1><i class="icon"/><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div>-subheader</h1>',
                ],
            ],
            [
                'node_name' => 'p',
                'find_name' => null,
                'equals' => [
                    '<p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                    '<p>Last text</p>',
                    '<p>First description</p>',
                    '<p><div role="article"><p><span class="header">new elem first</span></p><p class="info">new elem last</p></div></p>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider replaceTextProvider
     *
     * @throws \Exception
     */
    public function testReplaceText(string $elem_name, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->replaceText('test_text'), $equals);
    }

    /**
     * @return array[]
     */
    public function replaceTextProvider(): array
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
                'node_name' => 'h1',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>test_text</h1>',
                ],
            ],
            [
                'node_name' => '//div/h1',
                'equals' => [
                    '<h1><i class="icon"/><span>Header</span>test_text</h1>',
                ],
            ],
            [
                'node_name' => 'i',
                'equals' => [
                    '<i class="icon">test_text</i>',
                ],
            ],
            [
                'node_name' => 'p',
                'equals' => [
                    '<p><span class="text">First text</span>test_text</p>',
                    '<p>test_text</p>',
                    '<p>test_text</p>',
                    '<p><span>Last description</span>test_text</p>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string $attr
     * @param  string $value
     * @param array|null $equals
     *
     * @return void
     *
     * @dataProvider setAttrProvider
     *
     * @throws \Exception
     */
    public function testSetAttr(string $elem_name, string $attr, string $value, ?array $equals): void
    {
        $this->assertEqualsNodesContent($this->nodes->find($elem_name)->setAttr($attr, $value), $equals);
    }

    /**
     * @return array[]
     */
    public function setAttrProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'attr' => '',
                'value' => '',
                'equals' => null,
            ],
            [
                'node_name' => 'hr',
                'attr' => '',
                'value' => '',
                'equals' => null,
            ],
            [
                'node_name' => 'img',
                'attr' => 'src',
                'value' => 'test.jpg',
                'equals' => [
                    '<img src="test.jpg" alt="content img"/>',
                ],
            ],
            [
                'node_name' => 'img',
                'attr' => 'alt',
                'value' => 'test',
                'equals' => [
                    '<img src="content_img.jpg" alt="test"/>',
                ],
            ],
            [
                'node_name' => 'img',
                'attr' => 'class',
                'value' => 'img',
                'equals' => [
                    '<img src="content_img.jpg" alt="content img" class="img"/>',
                ],
            ],
            [
                'node_name' => 'div',
                'attr' => 'class',
                'value' => 'content',
                'equals' => [
                    '<div class="content"><div class="content"><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>',
                    '<div class="content"><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<div class="content" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>',
                ],
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider textProvider
     */
    public function testText(string $elem_name, string $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->text(), $equals);
    }

    /**
     * @return array[]
     */
    public function textProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'equals' => '',
            ],
            [
                'node_name' => 'hr',
                'equals' => '',
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
                'node_name' => 'div',
                'equals' => 'Header-subheaderFirst textLast text' . PHP_EOL . 'Header-subheaderFirst text' . PHP_EOL
                    . 'First descriptionMiddle descriptionLast description',
            ],
        ];
    }

    /**
     * @param string $elem_name
     * @param string $equals
     *
     * @return void
     *
     * @dataProvider typeProvider
     */
    public function testType(string $elem_name, string $equals): void
    {
        $this->assertEquals($this->nodes->find($elem_name)->type(), $equals);
    }

    /**
     * @return array[]
     */
    public function typeProvider(): array
    {
        return [
            [
                'node_name' => 'main',
                'equals' => '',
            ],
            [
                'node_name' => 'hr',
                'equals' => '',
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
            [
                'node_name' => 'div',
                'equals' => '1' . PHP_EOL . '1' . PHP_EOL . '1',
            ],
        ];
    }
}
