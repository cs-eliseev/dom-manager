<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

use cse\DOMManager\Nodes\NodeList;

class NodeListParserTest extends \Tests\BaseTestCase
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
        $domDocumentConverter = new \cse\DOMManager\Handlers\ContentParsers\NodeListParser();

        $this->assertEquals($domDocumentConverter->parse($content), $content);
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
