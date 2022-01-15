<?php

declare(strict_types=1);

namespace Unit\Handlers\ContentParsers;

use cse\DOMManager\Exceptions\EmptyContentException;
use cse\DOMManager\Exceptions\ReaderException;
use cse\DOMManager\Handlers\ContentParsers\StringParser;
use PHPUnit\Framework\Error\Notice;

class StringParserTest extends \Tests\BaseTestCase
{
    /**
     * @param string $content
     *
     * @return void
     *
     * @dataProvider parseProvider
     */
    public function testParse(string $content): void
    {
        $reader = new StringParser();
        $this->assertTrue($reader->parse($content)->exist());
    }

    /**
     * @return array
     */
    public function parseProvider(): array
    {
        return [
            [
                'content' => $this->getFileContent('example-1.xml'),
            ],
            [
                'content' => $this->getFileContent('example-2.html'),
            ],
        ];
    }

    /**
     * @param mixed $content
     * @param string $exception
     *
     * @return void
     *
     * @dataProvider parseExceptionProvider
     */
    public function testParseException($content, string $exception): void
    {
        $this->expectException($exception);
        $reader = new StringParser();
        $reader->parse($content);
    }

    /**
     * @return array[]
     */
    public function parseExceptionProvider(): array
    {
        return [
            [
                'content' => '<div><img></div>',
                'exception' => ReaderException::class
            ],
            [
                'content' => '<div><br></div>',
                'exception' => ReaderException::class
            ],
            [
                'content' => '<div><hr></div>',
                'exception' => ReaderException::class
            ],
            [
                'content' => '<div><link></div>',
                'exception' => ReaderException::class
            ],
            [
                'content' => '',
                'exception' => EmptyContentException::class
            ],
            [
                'content' => 'test text',
                'exception' => ReaderException::class
            ],
            [
                'content' => 1,
                'exception' => ReaderException::class
            ],
            [
                'content' => true,
                'exception' => ReaderException::class
            ],
            [
                'content' => 0.1,
                'exception' => ReaderException::class
            ],
            [
                'content' => ['asd'],
                'exception' => Notice::class
            ],
        ];
    }
}
