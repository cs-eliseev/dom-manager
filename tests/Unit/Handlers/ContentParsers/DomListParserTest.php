<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

class DomListParserTest extends \Tests\BaseTestCase
{
    /**
     * @return void
     */
    public function testParse(): void
    {
        $domDocument = new \DOMDocument('1.0', 'UTF-8');

        $node = $domDocument->createElement('test', 'First list element!');
        $domDocument->appendChild($node);
        $node = $domDocument->createElement('test', 'Last list element!');
        $domDocument->appendChild($node);

        $domConverter = new \cse\DOMManager\Handlers\ContentParsers\DomListParser();
        $nodes = $domConverter->parse($domDocument->getElementsByTagName('test'));

        $this->assertTrue($nodes->exist());
    }
}
