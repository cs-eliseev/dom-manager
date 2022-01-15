<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\DomNode;

use cse\DOMManager\Contracts\IDomNodeXPathHandleable;

final class XPathHandler implements IDomNodeXPathHandleable
{
    protected const XPATH_PREFIX = 'php';
    protected const XPATH_NAMESPACE = 'http://php.net/xpath';

    /**
     * @param string $query
     * @param \DOMNode $domNode
     *
     * @return \DOMNodeList|null
     */
    public function filter(string $query, \DOMNode $domNode): ?\DOMNodeList
    {
        return $this->createDOMXPath($domNode->ownerDocument)->query($query, $domNode);
    }

    /**
     * @param \DOMDocument $document
     *
     * @return \DOMXPath
     */
    protected function createDOMXPath(\DOMDocument $document): \DOMXPath
    {
        $domXPath = new \DOMXPath($document);
        $domXPath->registerNamespace(self::XPATH_PREFIX, self::XPATH_NAMESPACE);
        $domXPath->registerPhpFunctions();

        return $domXPath;
    }
}
