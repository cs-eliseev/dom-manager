<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface IContentParsable
{
    /**
     * @param string|\DOMNode|\DOMNodeList|\DOMDocument|INodesInstance|INodeListInstance $content
     *
     * @return INodeListInstance
     */
    public function parse($content): INodeListInstance;
}
