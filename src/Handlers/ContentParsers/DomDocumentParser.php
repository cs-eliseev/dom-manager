<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\ContentParsers;

use cse\DOMManager\Contracts\INodeListInstance;
use DOMDocument;

class DomDocumentParser extends AbstractParser
{
    /**
     * @param DOMDocument $domDocument
     *
     * @return INodeListInstance
     */
    public function convertToNodes(DOMDocument $domDocument): INodeListInstance
    {
        return $this->nodeList->push($domDocument->documentElement);
    }

    /**
     * @param DOMDocument $content
     *
     * @return INodeListInstance
     */
    protected function handle($content): INodeListInstance
    {
        return $this->convertToNodes($content);
    }
}
