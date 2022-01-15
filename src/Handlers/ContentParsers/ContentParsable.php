<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\IContentParsable;
use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodesInstance;
use cse\DOMManager\Contracts\IParserInstance;
use cse\DOMManager\Exceptions\ContentIsNotExistException;
use cse\DOMManager\Exceptions\UndefinedContentTypeException;
use DOMDocument;
use DOMNode;
use DOMNodeList;

class ContentParsable implements IContentParsable
{
    /** @var INodeListInstance $nodeList */
    protected $nodeList;

    /**
     * ContentParser constructor.
     *
     * @param INodeListInstance $nodeList
     */
    public function __construct(INodeListInstance $nodeList)
    {
        $this->nodeList = $nodeList;
    }

    /**
     * @param string|DOMNode|DOMNodeList|DOMDocument|INodesInstance|INodeListInstance $content
     *
     * @return INodeListInstance
     *
     * @throws ContentIsNotExistException
     * @throws UndefinedContentTypeException
     */
    public function parse($content): INodeListInstance
    {
        $instance = $this->makeParserInstanceByContent($content);
        return $instance->parse($content);
    }

    /**
     * @param string|string[]|DOMNode|DOMNodeList|DOMDocument|INodesInstance|INodeListInstance $content
     *
     * @return IParserInstance
     *
     * @throws ContentIsNotExistException
     * @throws UndefinedContentTypeException
     */
    public function makeParserInstanceByContent($content): IParserInstance
    {
        switch (true) {
            case is_string($content):
                $instance = new StringParser();
                break;
            case is_array($content):
                $instance = new ListParser();
                break;
            case $content instanceof DOMDocument:
                $instance = new DomDocumentParser();
                break;
            case $content instanceof DOMNodeList:
                $instance = new DomListParser();
                break;
            case $content instanceof DOMNode:
                $instance = new DomNodeParser();
                break;
            case $content instanceof INodesInstance:
                $instance = new NodesParser();
                break;
            case $content instanceof INodeListInstance:
                $instance = new NodeListParser();
                break;
            case is_null($content):
                throw new ContentIsNotExistException();
            default:
                throw new UndefinedContentTypeException();
        }
        $instance->setNodeList($this->nodeList->new());

        return $instance;
    }
}
