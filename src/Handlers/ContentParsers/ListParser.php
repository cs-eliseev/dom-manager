<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodesInstance;
use cse\DOMManager\Exceptions\ReaderException;
use cse\DOMManager\Handlers\Validations\StringValidator;

class ListParser extends AbstractParser
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
     * @param array $list
     * @param string $charset
     *
     * @return INodeListInstance
     *
     * @throws ReaderException
     */
    public function convertToNodes(array $list, string $charset = self::DEFAULT_CHARSET): INodeListInstance
    {
        foreach ($list as $content) {
            try {
                $this->parseByType($content, $charset);
            } catch (\Exception $e) {
                throw new ReaderException($e->getMessage(), $e->getCode());
            }
        }

        return $this->nodeList;
    }

    /**
     * @param INodeListInstance|INodesInstance|\DOMDocument|\DOMNode|\DOMNodeList|string|array $content
     *
     * @return INodeListInstance
     *
     * @throws ReaderException
     */
    protected function handle($content): INodeListInstance
    {
        return $this->convertToNodes((array) $content);
    }

    /**
     * @param INodeListInstance|INodesInstance|\DOMDocument|\DOMNode|\DOMNodeList|string|array $content
     * @param string $charset
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function parseByType($content, string $charset = self::DEFAULT_CHARSET): void
    {
        switch (true) {
            case is_string($content):
                $this->nodeListPushString($content, $charset);
                break;
            case is_array($content):
                $this->convertToNodes($content);
                break;
            case $content instanceof \DOMDocument:
                $this->nodeList->push($content->documentElement);
                break;
            case $content instanceof \DOMNodeList:
                $this->nodeListPushDomNodes(iterator_to_array($content));
                break;
            case $content instanceof \DOMNode:
                $this->nodeList->push($content);
                break;
            case $content instanceof INodesInstance:
                $this->nodeListPushDomNodes($content->toList()->all());
                break;
            case $content instanceof INodeListInstance:
                $this->nodeListPushDomNodes($content->all());
                break;
        }
    }

    /**
     * @param \DomNode[] $domNodeList
     *
     * @return void
     */
    protected function nodeListPushDomNodes(array $domNodeList): void
    {
        foreach ($domNodeList as $domNode) {
            $this->nodeList->push($domNode);
        }
    }

    /**
     * @param string $content
     * @param string $charset
     *
     * @return void
     */
    protected function nodeListPushString(string $content, string $charset): void
    {
        if ($content !== '') {
            $domDocument = new \DOMDocument(self::DOCUMENT_VERSION, $charset);
            $domDocument->loadXML($content);
            $this->nodeList->push($domDocument->documentElement);
        }
    }
}
