<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\DomNode;

use cse\DOMManager\Contracts\IDomNodeHandleable;
use cse\DOMManager\Contracts\IDomNodeXPathHandleable;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMText;

final class DomNodeHandler implements IDomNodeHandleable
{
    /** @var IDomNodeXPathHandleable $xPath */
    protected $xPath;

    /**
     * DomNodeService constructor.
     *
     * @param IDomNodeXPathHandleable $xPath
     */
    public function __construct(IDomNodeXPathHandleable $xPath)
    {
        $this->xPath = $xPath;
    }

    /**
     * @param DOMNode $parentDomNode
     * @param DOMNode $childNewDomNode
     *
     * @return DOMNode
     */
    public function appendChild(DOMNode &$parentDomNode, DOMNode $childNewDomNode): DOMNode
    {
        $childNewDomNode = $parentDomNode->ownerDocument->importNode($childNewDomNode, true);
        $parentDomNode->appendChild($childNewDomNode);

        return $childNewDomNode;
    }

    /**
     * @param string $node_name
     * @param DOMNode $domNode
     *
     * @return DOMNode|null
     */
    public function closest(string $node_name, DOMNode $domNode): ?DOMNode
    {
        do {
            $domNode = $domNode instanceof DOMElement ? $domNode->parentNode : null;

            if (isset($domNode) && $domNode->nodeName == $node_name) {
                return $domNode;
            }
        } while ($domNode != null);

        return $domNode;
    }

    /**
     * @param DOMNode $domNode
     *
     * @return string
     */
    public function content(DOMNode $domNode): string
    {
        return $domNode->ownerDocument->saveXML($domNode);
    }

    /**
     * @param string $query
     * @param DOMNode $domNode
     *
     * @return DOMNodeList
     */
    public function filter(string $query, DOMNode $domNode): DOMNodeList
    {
        $domList = $domNode->getElementsByTagName($query);
        return $domList->count() > 0 ? $domList : ($this->xPath->filter($query, $domNode) ?? new DOMNodeList());
    }

    /**
     * @param DOMNode $domNode
     *
     * @return DOMNode|null
     */
    public function rootElement(DOMNode $domNode): ?DOMNode
    {
        return $domNode->ownerDocument->documentElement;
    }

    /**
     * @param DOMNode $domNode
     *
     * @return DOMNode|null
     */
    public function parentElement(DOMNode $domNode): ?DOMNode
    {
        do {
            $domNode = $domNode instanceof DOMElement ? $domNode->parentNode : null;

            if (isset($domNode) && $this->isElem($domNode)) {
                return $domNode;
            }
        } while ($domNode != null);

        return $domNode;
    }

    /**
     * @param DOMNode $domNode
     *
     * @return bool
     */
    public function isText(DOMNode $domNode): bool
    {
        return $domNode instanceof DOMText;
    }

    /**
     * @param DOMNode $domNode
     *
     * @return bool
     */
    public function isElem(DOMNode $domNode): bool
    {
        return $domNode->nodeType == 1;
    }

    /**
     * @param DOMNode $domNode
     *
     * @return DOMNode|null
     */
    public function remove(DOMNode &$domNode): ?DOMNode
    {
        $parentDomNode = $domNode->parentNode;
        $domNode->parentNode->removeChild($domNode);

        return $this->isElem($parentDomNode) ? $parentDomNode : null;
    }

    /**
     * @param string $new_name
     * @param DOMNode $domNode
     *
     * @return DOMNode
     */
    public function rename(string $new_name, DOMNode &$domNode): DOMNode
    {
        $newDomNode = $domNode->ownerDocument->createElement($new_name);
        if ($domNode->attributes->length) {
            foreach ($domNode->attributes as $attribute) {
                $newDomNode->setAttribute($attribute->nodeName, $attribute->nodeValue);
            }
        }
        while ($domNode->firstChild) {
            $newDomNode->appendChild($domNode->firstChild);
        }
        $domNode->parentNode->replaceChild($newDomNode, $domNode);
        return $newDomNode;
    }

    /**
     * @param DOMNode $domNode
     * @param DOMNode $newDomNode
     *
     * @return DOMNode
     */
    public function replace(DOMNode &$domNode, DOMNode $newDomNode): DOMNode
    {
        $newDomNode = $domNode->ownerDocument->importNode($newDomNode, true);
        $domNode->parentNode->replaceChild($newDomNode, $domNode);

        return $newDomNode;
    }
}
