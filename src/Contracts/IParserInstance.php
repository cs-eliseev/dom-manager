<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface IParserInstance
{
    /**
     * @param string|\DOMDocument|\DOMNode|\DOMNodeList|INodesInstance|INodeListInstance $content
     *
     * @return INodeListInstance
     */
    public function parse($content): INodeListInstance;
}
