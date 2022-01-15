<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface IDomNodeHandleable
{
    /**
     * @param \DOMNode $parentDomNode
     * @param \DOMNode $childNewDomNode
     *
     * @return \DOMNode
     */
    public function appendChild(\DOMNode &$parentDomNode, \DOMNode $childNewDomNode): \DOMNode;

    /**
     * @param string $node_name
     * @param \DOMNode $domNode
     *
     * @return \DOMNode|null
     */
    public function closest(string $node_name, \DOMNode $domNode): ?\DOMNode;

    /**
     * @param \DOMNode $domNode
     *
     * @return string
     */
    public function content(\DOMNode $domNode): string;

    /**
     * @param string $query
     * @param \DOMNode $domNode
     *
     * @return \DOMNodeList
     */
    public function filter(string $query, \DOMNode $domNode): \DOMNodeList;

    /**
     * @param \DOMNode $domNode
     *
     * @return \DOMNode|null
     */
    public function rootElement(\DOMNode $domNode): ?\DOMNode;

    /**
     * @param \DOMNode $domNode
     *
     * @return \DOMNode|null
     */
    public function parentElement(\DOMNode $domNode): ?\DOMNode;

    /**
     * @param \DOMNode $domNode
     *
     * @return bool
     */
    public function isText(\DOMNode $domNode): bool;

    /**
     * @param \DOMNode $domNode
     *
     * @return bool
     */
    public function isElem(\DOMNode $domNode): bool;

    /**
     * @param \DOMNode $domNode
     *
     * @return \DOMNode|null
     */
    public function remove(\DOMNode &$domNode): ?\DOMNode;

    /**
     * @param string $new_name
     * @param \DOMNode $domNode
     *
     * @return \DOMNode
     */
    public function rename(string $new_name, \DOMNode &$domNode): \DOMNode;

    /**
     * @param \DOMNode $domNode
     * @param \DOMNode $newDomNode
     *
     * @return \DOMNode
     */
    public function replace(\DOMNode &$domNode, \DOMNode $newDomNode): \DOMNode;
}
