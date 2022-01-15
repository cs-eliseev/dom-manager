<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

use cse\DOMManager\Exceptions\ContentIsNotExistException;
use cse\DOMManager\Exceptions\UndefinedContentTypeException;
use cse\DOMManager\Handlers\ContentParsers\ContentParsable;
use cse\DOMManager\Handlers\ContentParsers\DomDocumentParser;
use cse\DOMManager\Handlers\ContentParsers\DomListParser;
use cse\DOMManager\Handlers\ContentParsers\DomNodeParser;
use cse\DOMManager\Handlers\ContentParsers\NodeListParser;
use cse\DOMManager\Handlers\ContentParsers\NodesParser;
use cse\DOMManager\Handlers\ContentParsers\ListParser;
use cse\DOMManager\Handlers\ContentParsers\StringParser;
use cse\DOMManager\Nodes\NodeList;

class ContentParserTest extends \Tests\BaseTestCase
{
    /**
     * @param $content
     * @param string $instance
     *
     * @return void
     *
     * @throws \cse\DOMManager\Exceptions\ContentIsNotExistException
     * @throws \cse\DOMManager\Exceptions\UndefinedContentTypeException
     *
     * @dataProvider parseProvider
     */
    public function testParse($content, string $instance): void
    {
        $parser = new ContentParsable(new NodeList());
        $this->assertInstanceOf($instance, $parser->makeParserInstanceByContent($content));
    }

    /**
     * @return array[]
     */
    public function parseProvider(): array
    {
        $domManager = new \cse\DOMManager\DomManager();

        return [
            [
                'content' => '<div></div>',
                'instance' => StringParser::class,
            ],
            [
                'content' => [],
                'instance' => ListParser::class,
            ],
            [
                'content' => new \DOMNode(),
                'instance' => DomNodeParser::class,
            ],
            [
                'content' => new \DOMDocument(),
                'instance' => DomDocumentParser::class,
            ],
            [
                'content' => new \DOMNodeList(),
                'instance' => DomListParser::class,
            ],
            [
                'content' => NodeList::create()->push(new \DOMNode()),
                'instance' => NodeListParser::class,
            ],
            [
                'content' => $domManager->create(new \DOMNode()),
                'instance' => NodesParser::class,
            ],
        ];
    }

    /**
     * @param $content
     * @param string $instance
     *
     * @return void
     *
     * @dataProvider exceptionProvider
     *
     * @throws \Exception
     */
    public function testException($content, string $instance): void
    {
        $this->expectException($instance);
        $parser = new ContentParsable(new NodeList());
        $parser->makeParserInstanceByContent($content);
    }

    /**
     * @return array
     */
    public function exceptionProvider(): array
    {
        return [
            [
                'content' => true,
                'instance' => UndefinedContentTypeException::class,
            ],
            [
                'content' => 1,
                'instance' => UndefinedContentTypeException::class,
            ],
            [
                'content' => null,
                'instance' => ContentIsNotExistException::class,
            ],
        ];
    }
}
