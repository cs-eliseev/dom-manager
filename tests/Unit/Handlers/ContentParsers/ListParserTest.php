<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

use cse\DOMManager\Exceptions\ReaderException;
use cse\DOMManager\Handlers\ContentParsers\ListParser;
use cse\DOMManager\Nodes\NodeList;

class ListParserTest extends \Tests\BaseTestCase
{
    /**
     * @param array $content
     * @param int $count
     *
     * @return void
     *
     * @dataProvider parseProvider
     */
    public function testParse(array $content, int $count): void
    {
        $reader = new ListParser();
        $this->assertEquals($reader->parse($content)->count(), $count);
    }

    /**
     * @return array
     */
    public function parseProvider(): array
    {
        return [
            [
                'content' => [],
                'count' => 0,
            ],
            [
                'content' => [1, 0.1, true, ''],
                'count' => 0,
            ],
            [
                'content' => [
                    '<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>',
                    '<h1><i class="icon"/><span>Header</span>-subheader</h1>',
                    '<p>First description</p>',
                ],
                'count' => 3,
            ],
            [
                'content' => [
                    '<i class="icon"/>',
                ],
                'count' => 1,
            ],
            [
                'content' => [
                    '<i class="icon"/>',
                    '<span>Header</span>',
                ],
                'count' => 2,
            ],
            [
                'content' => [
                    '<i class="icon"/>',
                    1,
                    '<span>Header</span>',
                ],
                'count' => 2,
            ],
            [
                'content' => [
                    '<i class="icon"/>',
                    true,
                    '<span>Header</span>',
                ],
                'count' => 2,
            ],
            [
                'content' => [
                    '<i class="icon"/>',
                    0.1,
                    '<span>Header</span>',
                ],
                'count' => 2,
            ],
            [
                'content' => [
                    [
                        '<i class="icon"/>',
                        '<span>Header</span>',
                    ],
                ],
                'count' => 2,
            ],
            [
                'content' => [
                    [
                        '<i class="icon"/>',
                    ],
                    [
                        '<span>Header</span>',
                    ],
                ],
                'count' => 2,
            ],
            [
                'content' => [
                    new \DOMNode(),
                    '<i class="icon"/>',
                    NodeList::create()->push(new \DOMNode()),
                    $this->getDocumentByFileName(),
                ],
                'count' => 4,
            ],
            [
                'content' => [
                    $this->getDocumentByFileName()->getElementsByTagName('div'),
                    $this->getDocumentByFileName()->getElementsByTagName('p'),
                ],
                'count' => 7,
            ],
        ];
    }

    /**
     * @return void
     */
    public function testParseNode(): void
    {
        $reader = new ListParser();
        $this->assertEquals(
            $reader->parse([
                $this->domManager->create($this->getDocumentByFileName()->getElementsByTagName('div'))
            ])->count(),
            3
        );
    }

    /**
     * @param mixed $content
     * @param string $exception
     *
     * @return void
     *
     * @dataProvider checkParseException
     */
    public function testCheckParseException($content, string $exception): void
    {
        $this->expectException($exception);
        $reader = new ListParser();
        $reader->parse($content);
    }

    /**
     * @return array[]
     */
    public function checkParseException(): array
    {
        return [
            [
                'content' => [
                    '<i class="icon">',
                    '<span>Header</span>',
                ],
                'exception' => ReaderException::class,
            ],
            [
                'content' => [
                    '<i class="icon"/>',
                    '<span>Header</span>',
                    '<br>'
                ],
                'exception' => ReaderException::class,
            ],
            [
                'content' => [
                    '<i class="icon"/>',
                    'test text',
                    '<span>Header</span>',
                ],
                'exception' => ReaderException::class,
            ],
            [
                'content' => 'asd',
                'exception' => ReaderException::class,
            ],
        ];
    }
}
