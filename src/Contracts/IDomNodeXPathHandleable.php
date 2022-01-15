<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface IDomNodeXPathHandleable
{
    /**
     * @param string $query
     * @param \DOMNode $domNode
     *
     * @return \DOMNodeList|null
     */
    public function filter(string $query, \DOMNode $domNode): ?\DOMNodeList;
}
