<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

class DomNodeParserTest extends \Tests\BaseTestCase
{
    /**
     * @return void
     */
    public function testParse(): void
    {
        $domDocument = new \DOMDocument('1.0', 'UTF-8');

        $node = $domDocument->createElement('test', 'This is the root element!');

        $domConverter = new \cse\DOMManager\Handlers\ContentParsers\DomNodeParser();
        $nodes = $domConverter->parse($node);

        $this->assertTrue($nodes->exist());
    }
}
