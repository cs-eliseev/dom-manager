<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

use cse\DOMManager\Nodes\NodeList;

class NodesParserTest extends \Tests\BaseTestCase
{
    /**
     * @param NodeList $content
     *
     * @return void
     *
     * @dataProvider parseProvider
     */
    public function testParse(NodeList $content): void
    {
        $domManager = new \cse\DOMManager\DomManager();
        $domDocumentConverter = new \cse\DOMManager\Handlers\ContentParsers\NodesParser();

        $this->assertEquals($domDocumentConverter->parse($domManager->create($content)), $content);
    }

    /**
     * @return array[]
     */
    public function parseProvider(): array
    {
        return [
            [
                'content' => NodeList::create()->push(new \DOMNode()),
            ],
        ];
    }
}
