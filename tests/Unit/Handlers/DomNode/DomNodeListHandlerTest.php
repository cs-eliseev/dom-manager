<?php

declare(strict_types=1);

namespace Unit\Handlers\DomNode;

use cse\DOMManager\Handlers\DomNode\DomNodeListHandler;

class DomNodeListHandlerTest extends \Tests\BaseTestCase
{
    /**
     * @param string $node_name
     *
     * @return void
     *
     * @dataProvider toArrayProvider
     */
    public function testToArray(string $node_name): void
    {
        $domNodeListService = new DomNodeListHandler();

        $domNodeList = $this->getDocumentByFileName(self::FILE_EXAMPLE_2)->getElementsByTagName($node_name);

        $this->assertEquals(
            $domNodeList->count(),
            count($domNodeListService->toArray($domNodeList))
        );
    }

    /**
     * @return array
     */
    public function toArrayProvider(): array
    {
        return [
            [
                'node_name' => 'h1',
            ],
            [
                'node_name' => 'p',
            ],
            [
                'node_name' => 'div',
            ],
            [
                'node_name' => 'li',
            ],
            [
                'node_name' => 'main',
            ],
        ];
    }
}
