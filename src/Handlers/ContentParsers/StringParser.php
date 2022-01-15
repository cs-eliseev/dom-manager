<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Exceptions\ReaderException;
use cse\DOMManager\Handlers\Validations\StringValidator;
use DOMDocument;

class StringParser extends AbstractParser
{
    public const DEFAULT_CHARSET = 'UTF-8';

    protected const DOCUMENT_VERSION = '1.0';

    /** @var StringValidator $stringValidator */
    protected $stringValidator;

    /**
     * StringParser constructor.
     */
    public function __construct()
    {
        $this->stringValidator = new StringValidator();
    }

    /**
     * @param string $content
     * @param string $charset
     *
     * @return INodeListInstance
     *
     * @throws ReaderException
     * @throws \cse\DOMManager\Exceptions\EmptyContentException
     */
    public function convertToNodes(string $content, string $charset = self::DEFAULT_CHARSET): INodeListInstance
    {
        $this->stringValidator->notEmptyString($content);

        $domDocument = new DOMDocument(self::DOCUMENT_VERSION, $charset);
        try {
            $domDocument->loadXML($content);
        } catch (\Exception $e) {
            throw new ReaderException($e->getMessage(), $e->getCode());
        }

        return $this->nodeList->push($domDocument->documentElement);
    }

    /**
     * @param string $content
     *
     * @return INodeListInstance
     *
     * @throws ReaderException
     * @throws \cse\DOMManager\Exceptions\EmptyContentException
     */
    protected function handle($content): INodeListInstance
    {
        return $this->convertToNodes((string) $content);
    }
}
