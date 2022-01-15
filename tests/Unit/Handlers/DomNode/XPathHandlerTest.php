<?php

declare(strict_types=1);

namespace Unit\Handlers\DomNode;

use cse\DOMManager\Handlers\DomNode\XPathHandler;

class XPathHandlerTest extends \Tests\BaseTestCase
{
    /**
     * @param string $query
     * @param int $count
     *
     * @return void
     *
     * @dataProvider filterProvider
     */
    public function testFilter(string $query, int $count): void
    {
        $sPathService = new XPathHandler();

        $this->assertEquals(
            $sPathService->filter($query, $this->getDocumentByFileName(self::FILE_EXAMPLE_2)->documentElement)->count(),
            $count
        );
    }

    /**
     * @return array[]
     */
    public function filterProvider(): array
    {
        return [
            [
                'query' => './/*/section',
                'count' => 2,
            ],
            [
                'query' => '*/section',
                'count' => 2,
            ],
            [
                'query' => 'section/section',
                'count' => 2,
            ],
            [
                'query' => 'section',
                'count' => 1,
            ],
            [
                'query' => '//section',
                'count' => 3,
            ],
            [
                'query' => '*/*/*[@class=" language-nothing"]',
                'count' => 6,
            ],
            [
                'query' => '*/*/*[contains(@class, "language-nothing")]',
                'count' => 6,
            ],
            [
                'query' => '//*[contains(@class, "language-nothing")]',
                'count' => 12,
            ],
        ];
    }
}
