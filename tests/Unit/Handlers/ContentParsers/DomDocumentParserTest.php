<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

use cse\DOMManager\Handlers\ContentParsers\DomDocumentParser;

class DomDocumentParserTest extends \Tests\BaseTestCase
{
    /**
     * @param string $content
     * @param bool $is_html
     *
     * @return void
     *
     * @dataProvider parseProvider
     */
    public function testParse(string $content, bool $is_html): void
    {
        $domDocument = new \DOMDocument('1.0', 'UTF-8');
        if ($is_html) {
            $domDocument->loadHTML($content);
        } else {
            $domDocument->loadXML($content);
        }
        $domDocumentConverter = new DomDocumentParser();
        $nodeList = $domDocumentConverter->parse($domDocument);

        $this->assertTrue($nodeList->exist());
    }

    /**
     * @return array[]
     */
    public function parseProvider(): array
    {
        return [
            [
                'content' => '<div><br></div>',
                'is_html' => true,
            ],
            [
                'content' => '<div><br/></div>',
                'is_html' => true,
            ],
            [
                'content' => '<div><br/></div>',
                'is_html' => false,
            ],
        ];
    }
}
